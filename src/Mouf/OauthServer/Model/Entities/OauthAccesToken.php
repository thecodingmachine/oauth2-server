<?php

namespace Mouf\OauthServer\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth_access_tokens")
 * @ORM\Entity()
 */
class OauthAccessToken
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=255)
     */
    protected $id;

    /**
     * @var \Mouf\OauthServer\Model\Entities\OauthSession
     *
     * @ORM\ManyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\OauthSession", cascade={"persist"})
     */
    protected $session_id;


    /**
     * __construct
     */
    public function __construct()
    {
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
    public function getId()
    {
        return $this->id;
    }
}
