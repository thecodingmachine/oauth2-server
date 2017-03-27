<?php
namespace Mouf\OAuthServer\Controllers;

use League\OAuth2\Server\AuthorizationServer;

use Psr\Log\LoggerInterface;
use Mouf\Security\UserService\UserService;
use League\OAuth2\Server\Exception\AccessDeniedException;
use Mouf\Utils\Session\SessionManager\SessionManagerInterface;
use Mouf\OAuthServer\Model\Entities\SessionRepository;
use Mouf\Html\Template\TemplateInterface;
use Mouf\Html\HtmlElement\HtmlBlock;
use Mouf\OAuthServer\Views\AuthorizeView;
use League\OAuth2\Server\Entity\ScopeEntity;
use Mouf\Mvc\Splash\Annotations\URL;
use Mouf\Mvc\Splash\Annotations\Get;
use Mouf\Mvc\Splash\Annotations\Post;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Client credentials grant controller
 */
class OAuthController {

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
     * @var HttpFoundationFactory
     */
    private $httpFoundationFactory;

    /**
     * Controller's constructor.
     * @param LoggerInterface $logger The logger
     * @param AuthorizationServer $authorizationServer
     * @param UserService $userService
     * @param SessionManagerInterface $sessionManager
     * @param HttpFoundationFactory $httpFoundationFactory
     */
    public function __construct(LoggerInterface $logger, AuthorizationServer $authorizationServer,
    							UserService $userService, SessionManagerInterface $sessionManager,
    							SessionRepository $sessionRepository, TemplateInterface $template,
    							HtmlBlock $content, AuthorizeView $authorizeView, HttpFoundationFactory $httpFoundationFactory) {
        $this->logger = $logger;
        $this->authorizationServer = $authorizationServer;
        $this->userService = $userService;
        $this->sessionManager = $sessionManager;
        $this->sessionRepository = $sessionRepository;
        $this->template = $template;
        $this->content = $content;
        $this->authorizeView = $authorizeView;
        $this->httpFoundationFactory = $httpFoundationFactory;
    }

    /**
     * @Post()
     * @URL ("access_token")
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function accessToken(ServerRequestInterface $request) {
        $this->authorizationServer->setRequest($this->httpFoundationFactory->createRequest($request));

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
     * @Get()
     * @URL("oauth")
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse|RedirectResponse
     */
    public function oauth(ServerRequestInterface $request) {
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
    	$authParams = $this->removeUnserializeElement($authParams);

    	$_SESSION['oauth__server__authParams'] = $authParams;
    	// Everything is okay, save $authParams to the a session and redirect the user to sign-in
    	return new RedirectResponse(ROOT_URL.'signin');
    }
    
    /**
     * This function to remove the object server on the
     * authentification parmeters to set it in session
     * 
     * @param array $authParams
     * @return array
     */
    private function removeUnserializeElement($authParams) {
    	$authParams['client']->hydrate(['server' => null]);
    	foreach ($authParams['scopes'] as $scope) {
    		/* @var $scope ScopeEntity */
    		$scope->hydrate(['server' => null]);
    	}
    	return $authParams;
    }
    
    /**
     * This function to add the object server on the
     * authentification parmeters (from the session)
     *
     * @param array $authParams
     * @return array
     */
    private function addUnserializeElement($authParams) {
    	$authParams['client'] = clone $authParams['client'];
    	$authParams['client']->hydrate(['server' => $this->authorizationServer]);

    	$authParams['scopes'] = array_map(function($scope) {
    		/* @var $scope ScopeEntity */
    		$scope = clone $scope;
    		$scope->hydrate(['server' => $this->authorizationServer]);
    		return $scope;
    	}, $authParams['scopes']);

    	return $authParams;
    }

    /**
     * @Get()
     * @URL("signin")
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse|RedirectResponse
     */
    public function signin(ServerRequestInterface $request) {
    	
    	if ($this->userService->isLogged()) {
   			return new RedirectResponse(ROOT_URL.'authorize');
    	} else {
    		return new RedirectResponse(ROOT_URL.'login/');
    	
    	}
    }

    /**
     * @Get()
     * @URL("authorize")
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse|RedirectResponse
     */
    public function authorize(ServerRequestInterface $request) {

    	$this->sessionManager->start();

    	$authParams = $_SESSION['oauth__server__authParams'];
    	
    	$session = $this->sessionRepository->findOneBy(['owner_id' => $this->userService->getUserId(),
    			'client_id' => $authParams['client']->getName()
    	]);
    	if($session) {
    		$authParams = $this->addUnserializeElement($authParams);
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
     * @Post()
     * @URL("authorize")
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse|RedirectResponse
     */
    public function signinAuthorization(ServerRequestInterface $request) {

    	$this->sessionManager->start();
    	$authParams = $_SESSION['oauth__server__authParams'];
    	
	    // If the user authorizes the request then redirect the user back with an authorization code
	    if ($_POST['authorization'] === 'Approve') {
	    	$authParams = $this->addUnserializeElement($authParams);
	    	return $this->redirectToUrl($authParams);
	    }
	    
	    // The user denied the request so redirect back with a message
	    else {
	    	$this->userService->logoff();
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

    /**
     * @param $authParams
     * @return RedirectResponse
     */
    public function redirectToUrl($authParams) {

    	$redirectUri = $this->authorizationServer->getGrantType('authorization_code')->newAuthorizeRequest('user', $this->userService->getUserId(), $authParams);
    	return new RedirectResponse($redirectUri);
    }
}
