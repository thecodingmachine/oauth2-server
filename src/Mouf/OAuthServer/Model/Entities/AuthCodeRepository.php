<?php

namespace Mouf\OAuthServer\Model\Entities;

use League\OAuth2\Server\AbstractServer;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\AuthCodeInterface;
use Doctrine\ORM\EntityRepository;

class AuthCodeRepository extends EntityRepository implements AuthCodeInterface
{

    /**
     * Get the auth code
     *
     * @param string $code
     *
     * @return \League\OAuth2\Server\Entity\AuthCodeEntity | null
     */
    public function get($code)
    {
        $temp = $this->createQueryBuilder('a')
            ->where('a.id = :id')
            ->andWhere('a.expire_time >= :date')
            ->setParameter('id', $code)
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getOneOrNullResult()
            ;

        if(is_object($temp)){
            $token = new AuthCodeEntity($this->server);
            $token->setId($temp->getId());
            $token->setRedirectUri($temp->getClientRedirectUri());
            $token->setExpireTime($temp->getExpireTime());
            return $token;
        }
        return null;
    }

    /**
     * Create an auth code.
     *
     * @param string $token The token ID
     * @param integer $expireTime Token expire time
     * @param integer $sessionId Session identifier
     * @param string $redirectUri Client redirect uri
     *
     * @return void
     */
    public function create($token, $expireTime, $sessionId, $redirectUri)
    {
        $authCode = new AuthCode();
        $authCode->setId($token);
        $authCode->setExpireTime($expireTime);
        $authCode->setSessionId($sessionId);
        $authCode->setClientRedirectUri($redirectUri);

        $_em = $this->getEntityManager();
        $_em->persist($authCode);
        $_em->flush();
    }

    /**
     * Get the scopes for an access token
     *
     * @param \League\OAuth2\Server\Entity\AuthCodeEntity $token The auth code
     *
     * @return \League\OAuth2\Server\Entity\ScopeEntity[] Array of \League\OAuth2\Server\Entity\ScopeEntity
     */
    public function getScopes(AuthCodeEntity $token)
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
     * Associate a scope with an acess token
     *
     * @param \League\OAuth2\Server\Entity\AuthCodeEntity $token The auth code
     * @param \League\OAuth2\Server\Entity\ScopeEntity $scope The scope
     *
     * @return void
     */
    public function associateScope(AuthCodeEntity $token, ScopeEntity $scope)
    {
        $_em = $this->getEntityManager();
        $tempToken = $this->find($token->getId());
        $tempScope = $this->getEntityManager()->getRepository('Mouf\OAuthServer\Model\Entities\ScopeRepository')->find($scope->getId());

        if(is_object($tempToken) && is_object($tempScope)){
            $tempToken->addScope($tempScope);
            $_em->persist($tempToken);
            $_em->flush();
        }
    }

    /**
     * Delete an access token
     *
     * @param \League\OAuth2\Server\Entity\AuthCodeEntity $token The access token to delete
     *
     * @return void
     */
    public function delete(AuthCodeEntity $token)
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