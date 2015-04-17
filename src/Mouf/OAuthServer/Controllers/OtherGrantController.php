<?php
namespace Mouf\OAuthServer\Controllers;

use League\OAuth2\Server\AuthorizationServer;
use Mouf\Mvc\Splash\Controllers\Controller;

/**
 * Authorization server with authorization code grant
 */
class OtherGrantController extends Controller {

    /**
     * @var AuthorizationServer
     */
    private $authorizationServer;

    /**
     * Controller's constructor.
     * @param AuthorizationServer $authorizationServer
     */
    public function __construct(AuthorizationServer $authorizationServer) {
        $this->authorizationServer = $authorizationServer;
    }

    /**
     * @URL /
     */
    public function index()
    {
    }
}
