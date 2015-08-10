<?php 
namespace Mouf\OAuthServer\Service;

use Mouf\Security\UserService\UserInterface;
use League\OAuth2\Server\Entity\SessionEntity;

class OAuthUser implements UserInterface {
	
	/**
	 * 
	 * @var SessionEntity
	 */
	private $sessionEntity;
	
	public function __construct(SessionEntity $sessionEntity) {
		$this->sessionEntity = $sessionEntity;
	}
	
	/**
	 * Returns the ID for the current user.
	 *
	 * @return string
	 */
	public function getId() {
		return $this->sessionEntity->getOwnerId();
	}
	
	/**
	 * Returns the login for the current user.
	 *
	 * @return string
	*/
	public function getLogin() {
		return $this->sessionEntity->getOwnerId();
	}

    /**
     *
     */
    public function getClient() {
        return $this->sessionEntity->getClient();
    }
}
