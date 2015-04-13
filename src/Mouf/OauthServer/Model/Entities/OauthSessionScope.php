<?php

namespace Mouf\OauthServer\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="oauth_session_scopes")
 * @ORM\Entity()
 */
class OauthSessionScope
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
     * @var \Mouf\OauthServer\Model\Entities\OauthSession
     *
     * @ORM\ManyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\OauthSession", cascade={"persist"})
     */
    protected $session_id;

    /**
     * @var \Mouf\OauthServer\Model\Entities\OauthScope
     *
     * @ORM\ManyToOne(targetEntity="\Mouf\OauthServer\Model\Entities\OauthScope", cascade={"persist"})
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
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param mixed $session_id
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }
}
