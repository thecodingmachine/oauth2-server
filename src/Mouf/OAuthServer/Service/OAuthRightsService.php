<?php
namespace Mouf\OAuthServer\Service;

use Mouf\Security\RightsService\RightsServiceInterface;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\Exception\AccessDeniedException;
use League\OAuth2\Server\Entity\ScopeEntity;

class OAuthRightsService implements RightsServiceInterface {

	/**
	 *
	 * @var ResourceServer
	 */
	private $resourceServer;
	
	public function __construct(ResourceServer $resourceServer) {
		$this->resourceServer = $resourceServer;
	}
	
	/**
	 * Returns true if the current user has the right passed in parameter.
	 * A scope can be optionnally passed.
	 * A scope can be anything from a string to an object. If it is an object,
	 * it must be serializable (because it will be stored in the session).
	 *
	 * @param string $right
	 * @param mixed $scope
	 */
	public function isAllowed($right, $scope = null) {
		try {
			$this->resourceServer->isValidRequest(false);
			$accessToken = $this->resourceServer->getAccessToken();
			$session = $this->resourceServer->getSessionStorage()->getByAccessToken($accessToken);
			$scopes = $session->getScopes();
			foreach ($scopes as $scopeEntity) {
				/* @var $scopeEntity ScopeEntity */
				if($right == $scopeEntity->getId()) {
					return true;
				}
			}
		}
		catch(AccessDeniedException $e) {
			return false;
		}
		return false;
	}
	
	/**
	 * Returns true if the user whose id is $user_id has the $right.
	 * A scope can be optionnally passed.
	 * A scope can be anything from a string to an object. If it is an object,
	 * it must be serializable (because it will be stored in the session).
	 *
	 * @param string $user_id
	 * @param string $right
	 * @param mixed $scope
	*/
	public function isUserAllowed($user_id, $right, $scope = null) {
		throw new \Exception('Not implemented: Impossible to get right for another user using OAuth service');
	}
	/**
	 * Rights are cached in session, this function will purge the rights in session.
	 * This can be useful if you know the rights previously fetched for
	 * the current user will change.
	 *
	*/
	public function flushRightsCache() {
		//Nothing
	}
	
	/**
	 * If the user has not the requested right, this function will
	 * redirect the user to an error page (or a login page...)
	 *
	 * @param string $right
	 * @param mixed $scope
	*/
	public function redirectNotAuthorized($right, $scope = null) {
		header('HTTP/1.0 403 Forbidden');
		exit;
	}

}