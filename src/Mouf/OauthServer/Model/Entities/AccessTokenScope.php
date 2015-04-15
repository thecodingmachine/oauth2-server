<?php

namespace Mouf\OauthServer\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth_access_token_scopes")
 * @ORM\Entity()
 */
class AccessTokenScope
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
     * @var \Mouf\OauthServer\Model\Entities\AccessToken
     *
     * @ORM\ManyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\AccessToken", cascade={"persist"})
     */
    protected $access_token;

    /**
     * @var \Mouf\OauthServer\Model\Entities\OauthScope
     *
     * @ORM\MAnyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\Scope", cascade={"persist"})
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
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param AccessToken $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }
}
