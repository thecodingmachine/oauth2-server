<?php

namespace Mouf\OauthServer\Model\Entities;

use League\OAuth2\Server\AbstractServer;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\RefreshTokenEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use League\OAuth2\Server\Storage\AuthCodeInterface;
use League\OAuth2\Server\Storage\ClientInterface;
use League\OAuth2\Server\Storage\RefreshTokenInterface;
use Mouf\Doctrine\ORM\EntityManager;
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
        // TODO: Implement get() method.
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
        // TODO: Implement create() method.
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
        // TODO: Implement delete() method.
    }

    /**
     * Set the server
     *
     * @param \League\OAuth2\Server\AbstractServer $server
     */
    public function setServer(AbstractServer $server)
    {
        // TODO: Implement setServer() method.
    }
}