<?php

namespace Mouf\OauthServer\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth_auth_code_scopes")
 * @ORM\Entity()
 */
class AuthCodeScope
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Mouf\OauthServer\Model\Entities\AuthCode
     *
     * @ORM\ManyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\AuthCode", cascade={"persist"})
     */
    protected $auth_code;

    /**
     * @var \Mouf\OauthServer\Model\Entities\Scope
     *
     * @ORM\ManyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\Scope", cascade={"persist"})
     */
    protected $scope;


        /**
     * __construct
     */
    public function __construct()
    {
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return OauthScope
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param OauthScope $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return OauthAuthCode
     */
    public function getAuthCode()
    {
        return $this->auth_code;
    }

    /**
     * @param OauthAuthCode $auth_code
     */
    public function setAuthCode($auth_code)
    {
        $this->auth_code = $auth_code;
    }
}
