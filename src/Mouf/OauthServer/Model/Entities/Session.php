<?php

namespace Mouf\OauthServer\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth_sessions")
 * @ORM\Entity()
 */
class Session
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
     * @var string
     *
     * @ORM\Column(name="owner_type", type="string", length=255)
     */
    protected $owner_type;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_id", type="string", length=255)
     */
    protected $owner;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\Client", cascade={"persist"})
     */
    protected $client;

    /**
     * @var string
     *
     * @ORM\Column(name="client_redirect_uri", type="string", length=255, nullable=true)
     */
    protected $client_redirect_uri;


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
    public function getOwnerType()
    {
        return $this->owner_type;
    }

    /**
     * @param string $owner_type
     */
    public function setOwnerType($owner_type)
    {
        $this->owner_type = $owner_type;
    }

    /**
     * @return string
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @param string $owner_id
     */
    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param string $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
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
}
