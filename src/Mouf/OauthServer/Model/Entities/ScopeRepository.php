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
use League\OAuth2\Server\Storage\ScopeInterface;
use Mouf\Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ScopeRepository extends EntityRepository implements ScopeInterface
{
    /**
     * Return information about a scope
     *
     * @param string $scope The scope
     * @param string $grantType The grant type used in the request (default = "null")
     * @param string $clientId The client sending the request (default = "null")
     *
     * @return \League\OAuth2\Server\Entity\ScopeEntity | null
     */
    public function get($scope, $grantType = null, $clientId = null)
    {
        // TODO: Implement get() method.
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