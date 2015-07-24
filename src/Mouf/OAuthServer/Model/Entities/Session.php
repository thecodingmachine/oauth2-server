<?php

namespace Mouf\OAuthServer\Model\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth__sessions")
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
    protected $owner_id;

    /**
     * @var string
     *
     * @ORM\Column(name="client_id", type="string", length=255)
     */
    protected $client_id;

    /**
     * @var string
     *
     * @ORM\Column(name="client_redirect_uri", type="string", length=255, nullable=true)
     */
    protected $client_redirect_uri;

    /**
     * @var \Mouf\OAuthServer\Model\Entities\Scope[]
     *
     * @ORM\ManyToMany(targetEntity="\Mouf\OAuthServer\Model\Entities\Scope")
     * @ORM\JoinTable(name="oauth__session_scopes",
     *      joinColumns={@ORM\JoinColumn(name="session_id", referencedColumnName="id")},
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

    /**
     * @return Scope[]
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param Scope[] $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * @param Scope $scope
     */
    public function addScope(Scope $scope)
    {
    	if(!$this->hasScope($scope)) {
        	$this->scopes->add($scope);
    	}
    }
    
    public function hasScope(Scope $scopeSearch) {
    	foreach ($this->scopes as $scope) {
    		if($scope->getId() == $scopeSearch->getId()) {
    			return true;
    		}
    	}
    	return false;
    }
}
