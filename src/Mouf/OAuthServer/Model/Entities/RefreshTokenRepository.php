<?php

namespace Mouf\OauthServer\Model\Entities;

use League\OAuth2\Server\AbstractServer;
use League\OAuth2\Server\Entity\RefreshTokenEntity;
use League\OAuth2\Server\Storage\RefreshTokenInterface;
use Doctrine\ORM\EntityRepository;

class RefreshTokenRepository extends EntityRepository implements RefreshTokenInterface
{

    /**
     * Return a new instance of \League\OAuth2\Server\Entity\RefreshTokenEntity
     *
     * @param string $token
     *
     * @return \League\OAuth2\Server\Entity\RefreshTokenEntity | null
     */
    public function get($token)
    {
        $temp = $this->find($token);

        if(is_object($temp)){
            (new RefreshTokenEntity($this->server))
                ->setId($temp->getId())
                ->setExpireTime($temp->getExpireTime())
                ->setAccessTokenId($temp->getAccessToken());
        }
        return null;
    }

    /**
     * Create a new refresh token_name
     *
     * @param string $token
     * @param integer $expireTime
     * @param string $accessToken
     *
     * @return \League\OAuth2\Server\Entity\RefreshTokenEntity
     */
    public function create($token, $expireTime, $accessToken)
    {
        $refreshToken = new RefreshToken();
        $refreshToken->setId($token);
        $refreshToken->setExpireTime($expireTime);
        $refreshToken->setAccessToken($accessToken);

        $_em = $this->getEntityManager();
        $_em->persist($refreshToken);
        $_em->flush();
    }

    /**
     * Delete the refresh token
     *
     * @param \League\OAuth2\Server\Entity\RefreshTokenEntity $token
     *
     * @return void
     */
    public function delete(RefreshTokenEntity $token)
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