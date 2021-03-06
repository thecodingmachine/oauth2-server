<?php

namespace Mouf\OAuthServer\Model\Entities;

use League\OAuth2\Server\AbstractServer;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use Doctrine\ORM\EntityRepository;

class AccessTokenRepository extends EntityRepository implements AccessTokenInterface
{

    /**
     * Get an instance of Entity\AccessTokenEntity
     *
     * @param string $token The access token
     *
     * @return \League\OAuth2\Server\Entity\AccessTokenEntity | null
     */
    public function get($token)
    {
        $temp = $this->find($token);

        if(is_object($temp)){
            return (new AccessTokenEntity($this->server))
                ->setId($temp->getId())
                ->setExpireTime($temp->getExpireTime());
        }

        return null;
    }

    /**
     * Get the scopes for an access token
     *
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity $token The access token
     *
     * @return \League\OAuth2\Server\Entity\ScopeEntity[] Array of \League\OAuth2\Server\Entity\ScopeEntity
     */
    public function getScopes(AccessTokenEntity $token)
    {
        $temp = $this->find($token->getId());

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

    /**
     * Creates a new access token
     *
     * @param string $token The access token
     * @param integer $expireTime The expire time expressed as a unix timestamp
     * @param string|integer $sessionId The session ID
     *
     * @return void
     */
    public function create($token, $expireTime, $sessionId)
    {
        $newToken = new AccessToken();
        $newToken->setId($token);
        $newToken->setExpireTime($expireTime);
        $newToken->setSessionId($sessionId);

        $_em = $this->getEntityManager();
        $_em->persist($newToken);
        $_em->flush();
    }

    /**
     * Associate a scope with an acess token
     *
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity $token The access token
     * @param \League\OAuth2\Server\Entity\ScopeEntity $scope The scope
     *
     * @return void
     */
    public function associateScope(AccessTokenEntity $token, ScopeEntity $scope)
    {
        $_em = $this->getEntityManager();
        $tempToken = $this->find($token->getId());
        $tempScope = $this->getEntityManager()->getRepository('Mouf\OAuthServer\Model\Entities\Scope')->find($scope->getId());

        if(is_object($tempToken) && is_object($tempScope)){
            $tempToken->addScope($tempScope);
            $_em->persist($tempToken);
            $_em->flush();
        }
    }

    /**
     * Delete an access token
     *
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity $token The access token to delete
     *
     * @return void
     */
    public function delete(AccessTokenEntity $token)
    {
        $temp = $this->find($token->getId());

        $_em = $this->getEntityManager();
        $_em->remove($temp);
        $_em->flush();
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