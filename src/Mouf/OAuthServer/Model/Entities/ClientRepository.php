<?php

namespace Mouf\OAuthServer\Model\Entities;

use League\OAuth2\Server\AbstractServer;
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\ClientInterface;
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
        $query = $this->createQueryBuilder('c')
            ->where('c.id = :id');
        $params = array('id' => $clientId);

        if($clientSecret !== null){
            $query->andWhere('c.secret = :secret');
            $params['secret'] = $clientSecret;
        }

        $temp = $query->setParameters($params)->getQuery()->getOneOrNullResult();

        if(is_object($temp)){
            $client = new ClientEntity($this->server);
            $client->hydrate([
                'id'    =>  $temp->getId(),
                'name'  =>  $temp->getName(),
            ]);
            return $client;
        }
        return null;
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
        $temp = $this->createQueryBuilder('c')
            ->join('Mouf\OAuthServer\Model\Entities\Session', 's', 'c.id = s.client_id')
            ->where('s.id = :id')
            ->setParameters(array(
                'id'    => $session->getId()
            ))
            ->getQuery()
            ->getOneOrNullResult();

        if(is_object($temp)){
            $client = new ClientEntity($this->server);
            $client->hydrate([
                'id'    =>  $temp->getId(),
                'name'  =>  $temp->getName(),
            ]);
            return $client;
        }
        return null;
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