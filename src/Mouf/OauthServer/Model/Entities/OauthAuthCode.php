<?php

namespace Mouf\OauthServer\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth_auth_codes")
 * @ORM\Entity()
 */
class OauthAuthCode
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Mouf\OauthServer\Model\Entities\OauthSession
     *
     * @ORM\ManyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\OauthSession", cascade={"persist"})
     */
    protected $session_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="expire_time", type="integer", length=25)
     */
    protected $expire_time;

    /**
     * @var string
     *
     * @ORM\Column(name="client_redirect_uri", type="string", length=255)
     */
    protected $client_redirect_uri;

    /**
     * __construct
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getExpireTime()
    {
        return $this->expire_time;
    }

    /**
     * @param int $expire_time
     */
    public function setExpireTime($expire_time)
    {
        $this->expire_time = $expire_time;
    }

    /**
     * @return OauthSession
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param OauthSession $session_id
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    /**
     * @return string
     */
    public function getClientRedirectUri()
    {
        return $this->client_redirect_uri;
    }

    /**
     * @param string $client_redirect_uri
     */
    public function setClientRedirectUri($client_redirect_uri)
    {
        $this->client_redirect_uri = $client_redirect_uri;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
