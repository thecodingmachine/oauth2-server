<?php

namespace Mouf\OAuthServer\Server;

use League\OAuth2\Server\AuthorizationServer;

class MoufAuthorizationServer extends AuthorizationServer
{
    /**
     * Enable support for a grant
     *
     * @param array $grantTypes
     * @param null|string $identifier An identifier for the grant (autodetected if not passed)
     * @return MoufAuthorizationServer
     *
     * @internal param \League\OAuth2\Server\Grant\GrantTypeInterface[] $grantType
     */
    public function setGrantType(array $grantTypes, $identifier = null)
    {
        foreach($grantTypes as $grantType){
            if (is_null($identifier)) {
                $identifier = $grantType->getIdentifier();
            }

            // Inject server into grant
            $grantType->setAuthorizationServer($this);

            $this->grantTypes[$identifier] = $grantType;

            if (!is_null($grantType->getResponseType())) {
                $this->responseTypes[] = $grantType->getResponseType();
            }
        }


        return $this;
    }
}