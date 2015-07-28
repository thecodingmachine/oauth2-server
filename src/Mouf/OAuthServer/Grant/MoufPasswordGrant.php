<?php
namespace Mouf\OAuthServer\Grant;

use League\OAuth2\Server\Grant\PasswordGrant;
use Mouf\OAuthServer\Service\OAuthUserService;
use Mouf\Security\UserService\UserDaoInterface;
use Mouf\Security\UserService\UserService;

/**
 *
 */
class MoufPasswordGrant extends PasswordGrant {

    /**
     * @param UserDaoInterface $userDao
     * @param OAuthUserService $userService
     */
    public function __construct(UserDaoInterface $userDao, OAuthUserService $userService) {
        $this->setVerifyCredentialsCallback(function ($username, $password) use($userDao, $userService) {
            $userBean = $userDao->getUserByCredentials($username, $password);
            if ($userBean === null) {
                return false;
            } else {
                return $userBean->getId();
            }
        });
    }

}