<?php
namespace Mouf\OAuthServer;

use Mouf\Actions\InstallUtils;
use Mouf\Doctrine\ORM\Admin\DoctrineInstallUtils;
use Mouf\Installer\PackageInstallerInterface;
use Mouf\MoufManager;
use Mouf\Html\Renderer\RendererUtils;

class OAuthServerInstaller implements PackageInstallerInterface {

    /**
     * (non-PHPdoc)
     * @see \Mouf\Installer\PackageInstallerInterface::install()
     */
    public static function install(MoufManager $moufManager) {
        RendererUtils::createPackageRenderer($moufManager, "mouf/oauth2-server");
        $doctrineInstallUtils = new DoctrineInstallUtils($moufManager);

        $doctrineInstallUtils->registerAnnotationBasedEntities('Mouf\\OAuthServer\\Model\\Entities', 'vendor/mouf/oauth2-server/src/Mouf/OAuthServer/Model/Entities');

        $moufManager = MoufManager::getMoufManager();

        // These instances are expected to exist when the installer is run.
        $psr_errorLogLogger = $moufManager->getInstanceDescriptor('psr.errorLogLogger');
        $entityManager = $moufManager->getInstanceDescriptor('entityManager');

        // Let's create the instances.
        $oAuthController = InstallUtils::getOrCreateInstance('oAuthController', 'Mouf\\OAuthServer\\Controllers\\OAuthController', $moufManager);
        $authorizeView = InstallUtils::getOrCreateInstance('authorizeView', 'Mouf\\OAuthServer\\Views\\AuthorizeView', $moufManager);
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
                
        $userService = $moufManager->getInstanceDescriptor('userService');
        $sessionManager = $moufManager->getInstanceDescriptor('sessionManager');
        $bootstrapTemplate = $moufManager->getInstanceDescriptor('bootstrapTemplate');
        $block_content = $moufManager->getInstanceDescriptor('block.content');
        
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

        
        $oauthRightService = InstallUtils::getOrCreateInstance('oauthRightService', 'Mouf\\OAuthServer\\Service\\OAuthRightsService', $moufManager);
        $oauthUserService = InstallUtils::getOrCreateInstance('oauthUserService', 'Mouf\\OAuthServer\\Service\\OAuthUserService', $moufManager);
        $resourceServer = InstallUtils::getOrCreateInstance('resourceServer', 'League\\OAuth2\\Server\\ResourceServer', $moufManager);
        
        // oAuthController
        if (!$oAuthController->getConstructorArgumentProperty('logger')->isValueSet()) {
        	$oAuthController->getConstructorArgumentProperty('logger')->setValue($psr_errorLogLogger);
        }
        if (!$oAuthController->getConstructorArgumentProperty('authorizationServer')->isValueSet()) {
        	$oAuthController->getConstructorArgumentProperty('authorizationServer')->setValue($moufAuthorizationServer);
        }
        if (!$oAuthController->getConstructorArgumentProperty('userService')->isValueSet()) {
        	$oAuthController->getConstructorArgumentProperty('userService')->setValue($userService);
        }
        if (!$oAuthController->getConstructorArgumentProperty('sessionManager')->isValueSet()) {
        	$oAuthController->getConstructorArgumentProperty('sessionManager')->setValue($sessionManager);
        }
        if (!$oAuthController->getConstructorArgumentProperty('sessionRepository')->isValueSet()) {
        	$oAuthController->getConstructorArgumentProperty('sessionRepository')->setValue($sessionRepository);
        }
        if (!$oAuthController->getConstructorArgumentProperty('template')->isValueSet()) {
        	$oAuthController->getConstructorArgumentProperty('template')->setValue($bootstrapTemplate);
        }
        if (!$oAuthController->getConstructorArgumentProperty('content')->isValueSet()) {
        	$oAuthController->getConstructorArgumentProperty('content')->setValue($block_content);
        }
        if (!$oAuthController->getConstructorArgumentProperty('authorizeView')->isValueSet()) {
        	$oAuthController->getConstructorArgumentProperty('authorizeView')->setValue($authorizeView);
        }
        
        
        // Let's bind instances together.
        if (!$oauthRightService->getConstructorArgumentProperty('resourceServer')->isValueSet()) {
        	$oauthRightService->getConstructorArgumentProperty('resourceServer')->setValue($resourceServer);
        }
        if (!$oauthUserService->getConstructorArgumentProperty('resourceServer')->isValueSet()) {
        	$oauthUserService->getConstructorArgumentProperty('resourceServer')->setValue($resourceServer);
        }
        if (!$resourceServer->getConstructorArgumentProperty('sessionStorage')->isValueSet()) {
        	$resourceServer->getConstructorArgumentProperty('sessionStorage')->setValue($sessionRepository);
        }
        if (!$resourceServer->getConstructorArgumentProperty('accessTokenStorage')->isValueSet()) {
        	$resourceServer->getConstructorArgumentProperty('accessTokenStorage')->setValue($accessTokenRepository);
        }
        if (!$resourceServer->getConstructorArgumentProperty('clientStorage')->isValueSet()) {
        	$resourceServer->getConstructorArgumentProperty('clientStorage')->setValue($clientRepository);
        }
        if (!$resourceServer->getConstructorArgumentProperty('scopeStorage')->isValueSet()) {
        	$resourceServer->getConstructorArgumentProperty('scopeStorage')->setValue($scopeRepository);
        }
        

        $moufManager->rewriteMouf();
    }
}
