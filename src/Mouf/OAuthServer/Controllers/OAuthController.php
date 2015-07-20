<?php
namespace Mouf\OAuthServer\Controllers;

use League\OAuth2\Server\AuthorizationServer;
use Mouf\Mvc\Splash\Controllers\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Mouf\Security\UserService\UserService;
use League\OAuth2\Server\Exception\AccessDeniedException;
use Mouf\Utils\Session\SessionManager\SessionManagerInterface;
use Mouf\OAuthServer\Model\Entities\SessionRepository;
use Mouf\Html\Template\TemplateInterface;
use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\OAuthServer\Views\AuthorizeView;

/**
 * Client credentials grant controller
 */
class OAuthController extends Controller {

    /**
     * The logger used by this controller.
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var AuthorizationServer
     */
    private $authorizationServer;

    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;

    /**
     * @var SessionRepository
     */
    private $sessionRepository;

    /**
     * @var AuthorizeView
     */
    private $authorizeView;

    /**
     * @var TemplateInterface
     */
    private $template;

    /**
     * @var HtmlBlock
     */
    private $content;

    /**
     * Controller's constructor.
     * @param LoggerInterface $logger The logger
     * @param AuthorizationServer $authorizationServer
     * @param UserService $userService
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(LoggerInterface $logger, AuthorizationServer $authorizationServer,
    							UserService $userService, SessionManagerInterface $sessionManager,
    							SessionRepository $sessionRepository, TemplateInterface $template,
    							HtmlBlock $content, AuthorizeView $authorizeView) {
        $this->logger = $logger;
        $this->authorizationServer = $authorizationServer;
        $this->userService = $userService;
        $this->sessionManager = $sessionManager;
        $this->sessionRepository = $sessionRepository;
        $this->template = $template;
        $this->content = $content;
        $this->authorizeView = $authorizeView;
    }

    /**
     * @URL /access_token
     * @Post
     * @param Request $request
     * @return JsonResponse
     */
    public function accessToken(Request $request) {
        $this->authorizationServer->setRequest($request);

        try {

            $response = $this->authorizationServer->issueAccessToken();
            return new JsonResponse(
                $response,
                200,
                [
                    'Content-type'  =>  'application/json',
                    'Cache-Control' =>  'no-store',
                    'Pragma'        =>  'no-store'
                ]
            );

        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'error'     =>  $e->getMessage(),
                    'message'   =>  $e->getMessage()
                ],
                400
            );

        }
    }
    
    /**
     * @URL /oauth
     * @Get
     * @param Request $request
     * @return JsonResponse
     */
    public function oauth(Request $request) {
    	// First ensure the parameters in the query string are correct
    	try {
    	
    		$authParams = $this->authorizationServer->getGrantType('authorization_code')->checkAuthorizeParams();
    	
    	} catch (\Exception $e) {
    	
    		if ($e->shouldRedirect()) {
    			return new RedirectResponse($e->getRedirectUri());
    		}
    	
    		return new JsonResponse(
    				[
    						'error'     =>  $e->errorType,
    						'message'   =>  $e->getMessage()
    				],
    				$e->httpStatusCode, // All of the library's exception classes have a status code specific to the error
    				$e->getHttpHeaders() // Some exceptions have headers which need to be sent
    		);
    	
    	}
    	
    	$this->sessionManager->start();
    	$authParams['client']->hydrate(['server' => null]);
    	$_SESSION['oauth__server__authParams'] = $authParams;
    	// Everything is okay, save $authParams to the a session and redirect the user to sign-in
    	return new RedirectResponse(ROOT_URL.'signin');
    }
    

    /**
     * @URL /signin
     * @Get
     * @param Request $request
     * @return JsonResponse
     */
    public function signin(Request $request) {
    	
    	if ($this->userService->isLogged()) {
   			return new RedirectResponse(ROOT_URL.'authorize');
    	} else {
    		return new RedirectResponse(ROOT_URL.'login/');
    	
    	}
    }

    /**
     * @URL /authorize
     * @Get
     * @param Request $request
     * @return JsonResponse
     */
    public function authorize(Request $request) {

    	$this->sessionManager->start();

    	$authParams = $_SESSION['oauth__server__authParams'];
    	
    	$session = $this->sessionRepository->findOneBy(['owner_id' => $this->userService->getUserId(),
    			'client_id' => $authParams['client']->getName()
    	]);
    	if($session) {
    		return $this->redirectToUrl($authParams);
    	}
    	else {
	    	$this->authorizeView->clientName = $authParams['client']->getName();
	    	$this->authorizeView->scopes = $authParams['scopes'];
	
	    	$this->content->addHtmlElement($this->authorizeView);
	    	
	    	$this->template->toHtml();
			return;
    	}
    }

    /**
     * @URL /authorize
     * @Post
     * @param Request $request
     * @return JsonResponse
     */
    public function signinAuthorization(Request $request) {

    	$this->sessionManager->start();
    	$authParams = $_SESSION['oauth__server__authParams'];
    	$this->sessionManager->write_close();
    	$authParams['client']->hydrate(['server' => $this->authorizationServer]);
    	
	    // If the user authorizes the request then redirect the user back with an authorization code
	    if ($_POST['authorization'] === 'Approve') {
	    	return $this->redirectToUrl($authParams);
	    }
	    
	    // The user denied the request so redirect back with a message
	    else {
	    
	    	$error = new AccessDeniedException();
	    	$redirectUri = \League\OAuth2\Server\Util\RedirectUri::make(
	    			$authParams['redirect_uri'],
	    			[
	    					'error' =>  $error->errorType,
	    					'message'   =>  $error->getMessage()
	    			]
	    	);
	    
	    	$response = new RedirectResponse($redirectUri);
	    
	    	return $response;
	    }
    }
    
    public function redirectToUrl($authParams) {

    	$redirectUri = $this->authorizationServer->getGrantType('authorization_code')->newAuthorizeRequest('user', $this->userService->getUserId(), $authParams);
    	return new RedirectResponse($redirectUri);
    }
}
