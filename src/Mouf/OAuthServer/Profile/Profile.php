<?php
namespace Mouf\OAuthServer\Model\Profile;

use Mouf\Security\UserService\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
class Profile implements ProfileInterface {

	/**
	 * 
	 * @var UserService
	 */
	private $userService;

	public function  __construct(UserService $userService) {
		$this->userService = $userService;
	}
	
	/**
	 * @URL /me
	 * @see \Mouf\OAuthServer\Model\Profile\ProfileInterface::getProfile()
	 */
	public function getProfile(array $scopes = []) {
		$array = [];
		foreach ($scopes as $scope) {
			if($scope->getName() == 'client') {
				$array['login'] = $this->userService->getLoggedUser()->getLogin();
			}
		}
		return new JsonResponse($array);
	}	
}
