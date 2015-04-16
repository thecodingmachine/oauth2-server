<?php

namespace Mouf\OAuthServer\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth__auth_codes")
 * @ORM\Entity()
 */
class AuthCode
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="session_time", type="integer", length=25)
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
     * @var \Mouf\OAuthServer\Model\Entities\Scope[]
     *
     * @ORM\ManyToMany(targetEntity="\Mouf\OAuthServer\Model\Entities\Scope")
     * @ORM\JoinTable(name="oauth__auth_code_scopes",
     *      joinColumns={@ORM\JoinColumn(name="auth_code_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id")}
     *      )
     **/
    private $scopes;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->scopes = new ArrayCollection();
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

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Session
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param Session $session_id
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    /**
     * @return \Mouf\OAuthServer\Model\Entities\Scope[]
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param \Mouf\OAuthServer\Model\Entities\Scope[] $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     *  @param \Mouf\OAuthServer\Model\Entities\Scope $scope
     */
    public function addScope(Scope $scope)
    {
        $this->scopes->add($scope);
    }
}
