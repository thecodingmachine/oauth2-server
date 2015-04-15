<?php

namespace Mouf\OauthServer\Model\Entities;

use League\OAuth2\Server\AbstractServer;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use League\OAuth2\Server\Storage\AuthCodeInterface;
use League\OAuth2\Server\Storage\ClientInterface;
use Mouf\Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ClientRepository extends EntityRepository implements ClientInterface
{

    /**
     * Validate a client
     *
     * @param string $clientId The client's ID
     * @param string $clientSecret The client's secret (default = "null")
     * @param string $redirectUri The client's redirect URI (default = "null")
     * @param string $grantType The grant type used (default = "null")
     *
     * @return \League\OAuth2\Server\Entity\ClientEntity | null
     */
    public function get($clientId, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        // TODO: Implement get() method.
    }

    /**
     * Get the client associated with a session
     *
     * @param \League\OAuth2\Server\Entity\SessionEntity $session The session
     *
     * @return \League\OAuth2\Server\Entity\ClientEntity | null
     */
    public function getBySession(SessionEntity $session)
    {
        // TODO: Implement getBySession() method.
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