<?php

namespace Mouf\OAuthServer\Model\Entities;

use League\OAuth2\Server\AbstractServer;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\SessionInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class SessionRepository extends EntityRepository implements SessionInterface
{
    /**
     * Get a session from an access token
     *
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity $accessToken The access token
     *
     * @return \League\OAuth2\Server\Entity\SessionEntity | null
     */
    public function getByAccessToken(AccessTokenEntity $accessToken)
    {
        $temp = $this->createQueryBuilder('s')
            ->join('Mouf\OAuthServer\Model\Entities\AccessToken', 'a', Join::WITH, 's.id = a.session_id')
            ->where('a.id = :id')
            ->setParameters(array(
                'id'    => $accessToken->getId()
            ))
            ->getQuery()
            ->getOneOrNullResult();

        if(is_object($temp)){
            $session = new SessionEntity($this->server);
            $session->setId($temp->getId());
            $session->setOwner($temp->getOwnerType(), $temp->getOwnerId());
            return $session;
        }
        return null;
    }

    /**
     * Get a session from an auth code
     *
     * @param \League\OAuth2\Server\Entity\AuthCodeEntity $authCode The auth code
     *
     * @return \League\OAuth2\Server\Entity\SessionEntity | null
     */
    public function getByAuthCode(AuthCodeEntity $authCode)
    {
        $temp = $this->createQueryBuilder('s')
            ->join('Mouf\OAuthServer\Model\Entities\AuthCode', 'a', Join::WITH, 's.id = a.session_id')
            ->where('a.id = :id')
            ->setParameters(array(
                'id'    => $authCode->getId()
            ))
            ->getQuery()
            ->getOneOrNullResult();

        if(is_object($temp)){
            $session = new SessionEntity($this->server);
            $session->setId($temp->getId());
            $session->setOwner($temp->getOwnerType(), $temp->getOwnerId());
            return $session;
        }
        return null;
    }

    /**
     * Get a session's scopes
     *
     * @param  \League\OAuth2\Server\Entity\SessionEntity
     *
     * @return \League\OAuth2\Server\Entity\ScopeEntity[] Array of \League\OAuth2\Server\Entity\ScopeEntity
     */
    public function getScopes(SessionEntity $session)
    {
    	if($session->getId() == null) {
    		return [];
    	}
    	else {
	        $temp = $this->find($session->getId());
	
	        $response = array();
	        if(is_object($temp)){
	            foreach($temp->getScopes() as $scp){
	                $scope = (new ScopeEntity($this->server))->hydrate([
	                    'id'            =>  $scp->getId(),
	                    'description'   =>  $scp->getDescription(),
	                ]);
	                $response[] = $scope;
	            }
	        }
	
	        return $response;
    	}
    }

    /**
     * Create a new session
     *
     * @param string $ownerType Session owner's type (user, client)
     * @param string $ownerId Session owner's ID
     * @param string $clientId Client ID
     * @param string $clientRedirectUri Client redirect URI (default = null)
     *
     * @return integer The session's ID
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
    	$session = $this->findOneBy(['owner_type' => $ownerType,
    						'owner_id' => $ownerId,
    						'client_id' => $clientId
    					]);
    	if($session) {
    		$session->setClientRedirectUri($clientRedirectUri);
    	}
    	else {
	        $session = new Session();
	        $session->setOwnerType($ownerType);
	        $session->setOwnerId($ownerId);
	        $session->setClientId($clientId);
	        $session->setClientRedirectUri($clientRedirectUri);
    	}
    	
        $_em = $this->getEntityManager();
        $_em->persist($session);
        $_em->flush();
        
        return $session->getId();
    }

    /**
     * Associate a scope with a session
     *
     * @param \League\OAuth2\Server\Entity\SessionEntity $session The session
     * @param \League\OAuth2\Server\Entity\ScopeEntity $scope The scope
     *
     * @return void
     */
    public function associateScope(SessionEntity $session, ScopeEntity $scope)
    {
        $_em = $this->getEntityManager();
        $tempSession = $this->find($session->getId());
        $tempScope = $this->getEntityManager()->getRepository('Mouf\OAuthServer\Model\Entities\Scope')->find($scope->getId());

        if($tempSession && $tempScope){
            $tempSession->addScope($tempScope);
            $_em->persist($tempSession);
            $_em->flush();
        }
    }

    /**
     * Server
     *
     * @var \League\OAuth2\Server\AbstractServer $server
     */
    protected $server;

    /**
     * Set the server
     *
     * @param \League\OAuth2\Server\AbstractServer $server
     *
     * @return self
     */
    public function setServer(AbstractServer $server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Return the server
     *
     * @return \League\OAuth2\Server\AbstractServer
     */
    protected function getServer()
    {
        return $this->server;
    }
}