<?php
namespace Mouf\OAuthServer\Service;

use Doctrine\DBAL\Exception\InvalidArgumentException;
use Mouf\Security\UserService\UserServiceInterface;
use League\OAuth2\Server\ResourceServer;
use League\OAuth2\Server\Exception\AccessDeniedException;
use League\OAuth2\Server\Exception\InvalidRequestException;

class OAuthUserService implements UserServiceInterface {
	
	/**
	 * 
	 * @var ResourceServer
	 */
	private $resourceServer;

	public function __construct(ResourceServer $resourceServer) {
		$this->resourceServer = $resourceServer;
	}
	
	/**
	 * Logs the user using the provided login and password.
	 * Returns true on success, false if the user or password is incorrect.
	 *
	 * @param string $user
	 * @param string $password
	 * @return boolean.
	 */
	public function login($user, $password) {
		throw new \Exception('Not implemented: Impossible to login using OAuth service');
	}
	
	/**
	 * Logs the user using the provided login.
	 * The password is not needed if you use this function.
	 * Of course, you should use this functions sparingly.
	 * For instance, it can be useful if you want an administrator to "become" another
	 * user without requiring the administrator to provide the password.
	 *
	 * @param string $login
	*/
	public function loginWithoutPassword($login) {
		throw new \Exception('Not implemented: Impossible to login using OAuth service');
	}
	
	/**
	 * Logs a user using a token. The token should be discarded as soon as it
	 * was used.
	 *
	 * @param string $token
	*/
	public function loginViaToken($token) {
		throw new \Exception('Not implemented: Impossible to login using OAuth service');
	}
	
	/**
	 * Returns "true" if the user is logged, "false" otherwise.
	 *
	 * @return boolean
	*/
	public function isLogged() {
		try {
			$this->resourceServer->isValidRequest(false);
		}
		catch (AccessDeniedException $e) {
			return false;
		}
		catch (InvalidRequestException $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * Redirects the user to the login page if he is not logged.
	 *
	 * @return boolean
	*/
	public function redirectNotLogged() {
		header('HTTP/1.0 403 Forbidden');
		exit;
	}
	
	/**
	 * Logs the user off.
	 *
	*/
	public function logoff() {
		throw new \Exception('Not implemented: Impossible to login using OAuth service');
	}
	
	/**
	 * Returns the current user ID.
	 *
	 * @return string
	*/
	public function getUserId() {
		$info = $this->getSessionEntity();
		return ($info?$info->getOwnerId():null);
	}
	
	/**
	 * Returns the current user login.
	 *
	 * @return string
	*/
	public function getUserLogin() {
		return $this->getUserId();
	}
	
	/**
	 * Returns the user that is logged (or null if no user is logged).
	 *
	 * return UserInterface
	*/
	public function getLoggedUser() {
		$sessionEntity = $this->getSessionEntity();

		if ($sessionEntity) {
			return new OAuthUser($this->getSessionEntity());
		} else {
			return null;
		}
	}
	
	private function getSessionEntity() {
		if($this->isLogged()) {
			$accessToken = $this->resourceServer->getAccessToken();
			return $this->resourceServer->getSessionStorage()->getByAccessToken($accessToken);
		}
		return null;
	}
}