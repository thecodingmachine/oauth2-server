<?php

namespace Mouf\OAuthServer\Server;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\GrantTypeInterface;

class MoufAuthorizationServer extends AuthorizationServer
{
    /**
     * Enable support for a grant
     *
     * @param GrantTypeInterface[] $grantTypes  A grant class which conforms to Interface/GrantTypeInterface
     *
     * @return self
     */
    public function setGrantTypes(array $grantTypes)
    {
        foreach($grantTypes as $grantType){
            $this->addGrantType($grantType);
        }

        return $this;
    }
}