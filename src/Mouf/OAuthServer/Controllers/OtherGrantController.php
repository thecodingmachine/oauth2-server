<?php
namespace Mouf\OAuthServer\Controllers;

use League\OAuth2\Server\AuthorizationServer;
use Mouf\Mvc\Splash\Controllers\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Client credentials grant controller
 */
class OtherGrantController extends Controller {

    /**
     * The logger used by this controller.
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var AuthorizationServer
     */
    private $authorizationServer;

    /**
     * Controller's constructor.
     * @param LoggerInterface $logger The logger
     * @param AuthorizationServer $authorizationServer
     */
    public function __construct(LoggerInterface $logger, AuthorizationServer $authorizationServer) {
        $this->logger = $logger;
        $this->authorizationServer = $authorizationServer;
    }

    /**
     * @URL /access_token
     * @Post
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) {
        $this->authorizationServer->setRequest($request);

        try {

            $response = $this->authorizationServer->issueAccessToken();
            return new JsonResponse(
                json_encode($response),
                200,
                [
                    'Content-type'  =>  'application/json',
                    'Cache-Control' =>  'no-store',
                    'Pragma'        =>  'no-store'
                ]
            );

        } catch (\Exception $e) {

            return new JsonResponse(
                json_encode([
                    'error'     =>  $e->errorType,
                    'message'   =>  $e->getMessage()
                ]),
                $e->httpStatusCode,
                $e->getHttpHeaders()
            );

        }
    }
}
