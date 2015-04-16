<?php

namespace Mouf\OauthServer\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth__access_tokens")
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
     * @var integer
     *
     * @ORM\Column(name="session_id", type="integer", length=25)
     */
    protected $session_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="expire_time", type="integer", length=25)
     */
    protected $expire_time;

    /**
     * @var \Mouf\OAuthServer\Model\Entities\Scope[]
     *
     * @ORM\ManyToMany(targetEntity="\Mouf\OAuthServer\Model\Entities\Scope")
     * @ORM\JoinTable(name="oauth__access_token_scopes",
     *      joinColumns={@ORM\JoinColumn(name="access_token_id", referencedColumnName="id")},
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
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param int $session_id
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    /**
     * @return \Mouf\OAuthServer\Model\Entities\Scope[] $scopes
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
     * @param \Mouf\OAuthServer\Model\Entities\Scope $scope
     */
    public function addScope(Scope $scope)
    {
        $this->scopes->add($scope);
    }
}
