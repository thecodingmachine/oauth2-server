<?php

namespace Mouf\OauthServer\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth_access_tokens")
 * @ORM\Entity()
 */
class AccessToken
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=255)
     */
    protected $id;

    /**
     * @var \Mouf\OauthServer\Model\Entities\Session
     *
     * @ORM\OneToOne(targetEntity="\Mouf\OauthServer\Model\Entities\Session", cascade={"persist"})
     */
    protected $session;

    /**
     * @var integer
     *
     * @ORM\Column(nam="expire_time", type="integer", length=25)
     */
    protected $expire_time;


    /**
     * __construct
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     */
    public function setSession($session)
    {
        $this->session = $session;
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
}
