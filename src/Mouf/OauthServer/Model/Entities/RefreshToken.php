<?php

namespace Mouf\OauthServer\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth_refresh_tokens")
 * @ORM\Entity()
 */
class RefreshToken
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255)
     * @ORM\Id
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="expire_token", type="integer", length=255)
     */
    protected $expire_token;

    /**
     * @var \Mouf\OauthServer\Model\Entities\AccessToken
     *
     * @ORM\ManyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\AccessToken", cascade={"persist"})
     */
    protected $access_token;


    /**
     * __construct
     */
    public function __construct()
    {
    }

    /**
     * @return OauthAccessToken
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param OauthAccessToken $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return int
     */
    public function getExpireToken()
    {
        return $this->expire_token;
    }

    /**
     * @param int $expire_token
     */
    public function setExpireToken($expire_token)
    {
        $this->expire_token = $expire_token;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

}
