<?php
namespace Mouf\OAuthServer;

use Mouf\Actions\InstallUtils;
use Mouf\Doctrine\ORM\Admin\DoctrineInstallUtils;
use Mouf\Installer\PackageInstallerInterface;
use Mouf\MoufManager;

class OAuthServerInstaller implements PackageInstallerInterface {

    /**
     * (non-PHPdoc)
     * @see \Mouf\Installer\PackageInstallerInterface::install()
     */
    public static function install(MoufManager $moufManager) {
        $doctrineInstallUtils = new DoctrineInstallUtils($moufManager);

        $doctrineInstallUtils->registerAnnotationBasedEntities('Mouf\\OAuthServer\\Model\\Entities', 'vendor/mouf/oauth2-server/src/Mouf/OAuthServer/Model/Entities');

        $moufManager = MoufManager::getMoufManager();

        // These instances are expected to exist when the installer is run.
        $psr_errorLogLogger = $moufManager->getInstanceDescriptor('psr.errorLogLogger');
        $entityManager = $moufManager->getInstanceDescriptor('entityManager');

        // Let's create the instances.
        $oAuthController = InstallUtils::getOrCreateInstance('oAuthController', 'Mouf\\OAuthServer\\Controllers\\OAuthController', $moufManager);
        $authCodeRepository = InstallUtils::getOrCreateInstance('authCodeRepository', 'Mouf\\OAuthServer\\Model\\Entities\\AuthCodeRepository', $moufManager);
        $scopeRepository = InstallUtils::getOrCreateInstance('scopeRepository', 'Mouf\\OAuthServer\\Model\\Entities\\ScopeRepository', $moufManager);
        $refreshTokenRepository = InstallUtils::getOrCreateInstance('refreshTokenRepository', 'Mouf\\OAuthServer\\Model\\Entities\\RefreshTokenRepository', $moufManager);
        $clientRepository = InstallUtils::getOrCreateInstance('clientRepository', 'Mouf\\OAuthServer\\Model\\Entities\\ClientRepository', $moufManager);
        $accessTokenRepository = InstallUtils::getOrCreateInstance('accessTokenRepository', 'Mouf\\OAuthServer\\Model\\Entities\\AccessTokenRepository', $moufManager);
        $sessionRepository = InstallUtils::getOrCreateInstance('sessionRepository', 'Mouf\\OAuthServer\\Model\\Entities\\SessionRepository', $moufManager);
        $refrehTokenGrant = InstallUtils::getOrCreateInstance('refrehTokenGrant', 'League\\OAuth2\\Server\\Grant\\RefreshTokenGrant', $moufManager);
        $passwordGrant = InstallUtils::getOrCreateInstance('passwordGrant', 'League\\OAuth2\\Server\\Grant\\PasswordGrant', $moufManager);
        $clientCredentialsGrant = InstallUtils::getOrCreateInstance('clientCredentialsGrant', 'League\\OAuth2\\Server\\Grant\\ClientCredentialsGrant', $moufManager);
        $authCodeGrant = InstallUtils::getOrCreateInstance('authCodeGrant', 'League\\OAuth2\\Server\\Grant\\AuthCodeGrant', $moufManager);
        $moufAuthorizationServer = InstallUtils::getOrCreateInstance('moufAuthorizationServer', 'Mouf\\OAuthServer\\Server\\MoufAuthorizationServer', $moufManager);
        $anonymousClassMetadata = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata2 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata3 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata4 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata5 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata6 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');

        // Let's bind instances together.
        if (!$oAuthController->getConstructorArgumentProperty('logger')->isValueSet()) {
            $oAuthController->getConstructorArgumentProperty('logger')->setValue($psr_errorLogLogger);
        }
        if (!$oAuthController->getConstructorArgumentProperty('authorizationServer')->isValueSet()) {
            $oAuthController->getConstructorArgumentProperty('authorizationServer')->setValue($moufAuthorizationServer);
        }
        if (!$authCodeRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $authCodeRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$authCodeRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $authCodeRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata);
        }
        if (!$scopeRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $scopeRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$scopeRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $scopeRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata2);
        }
        if (!$refreshTokenRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $refreshTokenRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$refreshTokenRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $refreshTokenRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata3);
        }
        if (!$clientRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $clientRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$clientRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $clientRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata4);
        }
        if (!$accessTokenRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $accessTokenRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$accessTokenRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $accessTokenRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata5);
        }
        if (!$sessionRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $sessionRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$sessionRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $sessionRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata6);
        }
        if (!$moufAuthorizationServer->getSetterProperty('setGrantTypes')->isValueSet()) {
            $moufAuthorizationServer->getSetterProperty('setGrantTypes')->setValue(array(0 => $authCodeGrant, 1 => $clientCredentialsGrant, 2 => $passwordGrant, 3 => $refrehTokenGrant, ));
        }
        if (!$moufAuthorizationServer->getSetterProperty('setClientStorage')->isValueSet()) {
            $moufAuthorizationServer->getSetterProperty('setClientStorage')->setValue($clientRepository);
        }
        if (!$moufAuthorizationServer->getSetterProperty('setSessionStorage')->isValueSet()) {
            $moufAuthorizationServer->getSetterProperty('setSessionStorage')->setValue($sessionRepository);
        }
        if (!$moufAuthorizationServer->getSetterProperty('setAccessTokenStorage')->isValueSet()) {
            $moufAuthorizationServer->getSetterProperty('setAccessTokenStorage')->setValue($accessTokenRepository);
        }
        if (!$moufAuthorizationServer->getSetterProperty('setRefreshTokenStorage')->isValueSet()) {
            $moufAuthorizationServer->getSetterProperty('setRefreshTokenStorage')->setValue($refreshTokenRepository);
        }
        if (!$moufAuthorizationServer->getSetterProperty('setAuthCodeStorage')->isValueSet()) {
            $moufAuthorizationServer->getSetterProperty('setAuthCodeStorage')->setValue($authCodeRepository);
        }
        if (!$moufAuthorizationServer->getSetterProperty('setScopeStorage')->isValueSet()) {
            $moufAuthorizationServer->getSetterProperty('setScopeStorage')->setValue($scopeRepository);
        }
        $anonymousClassMetadata->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\AuthCode');
        $anonymousClassMetadata2->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\Scope');
        $anonymousClassMetadata3->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\RefreshToken');
        $anonymousClassMetadata4->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\Client');
        $anonymousClassMetadata5->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\AccessToken');
        $anonymousClassMetadata6->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\Session');


        $moufManager->rewriteMouf();
    }
}
