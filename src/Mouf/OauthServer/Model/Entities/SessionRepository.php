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
use League\OAuth2\Server\Storage\SessionInterface;
use Mouf\Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

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
        $temp = $this->find($accessToken);

        $session = new SessionEntity($this->server);
        $session->setId($temp->getId());
        $session->setOwner($temp->getOwnerType(), $temp->getOwener());
        return $session;
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
        // TODO: Implement getByAuthCode() method.
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
        // TODO: Implement getScopes() method.
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
        // TODO: Implement create() method.
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
        // TODO: Implement associateScope() method.
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