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

        $doctrineInstallUtils->registerAnnotationBasedEntities('Mouf\\OauthServer\\Model\\Entities', 'vendor/mouf/oauth2-server/src/Mouf/OAuthServer/Model/Entities');

        $moufManager = MoufManager::getMoufManager();

        // These instances are expected to exist when the installer is run.
        $entityManager = $moufManager->getInstanceDescriptor('entityManager');

        // Let's create the instances.
        InstallUtils::getOrCreateInstance('authCodeGrantController', 'Mouf\\OAuthServer\\Controllers\\AuthCodeGrantController', $moufManager);
        InstallUtils::getOrCreateInstance('otherCodeGrantController', 'Mouf\\OAuthServer\\Controllers\\OtherCodeGrantController', $moufManager);
        $accessTokenRepository = InstallUtils::getOrCreateInstance('accessTokenRepository', 'Mouf\\OAuthServer\\Model\\Entities\\AccessTokenRepository', $moufManager);
        $authCodeRepository = InstallUtils::getOrCreateInstance('authCodeRepository', 'Mouf\\OAuthServer\\Model\\Entities\\AuthCodeRepository', $moufManager);
        $clientRepository = InstallUtils::getOrCreateInstance('clientRepository', 'Mouf\\OAuthServer\\Model\\Entities\\ClientRepository', $moufManager);
        $refreshTokenRepository = InstallUtils::getOrCreateInstance('refreshTokenRepository', 'Mouf\\OAuthServer\\Model\\Entities\\RefreshTokenRepository', $moufManager);
        $scopeRepository = InstallUtils::getOrCreateInstance('scopeRepository', 'Mouf\\OAuthServer\\Model\\Entities\\ScopeRepository', $moufManager);
        $sessionRepository = InstallUtils::getOrCreateInstance('sessionRepository', 'Mouf\\OAuthServer\\Model\\Entities\\SessionRepository', $moufManager);
        $anonymousClassMetadata = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata2 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata3 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata4 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata5 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');
        $anonymousClassMetadata6 = $moufManager->createInstance('Doctrine\\ORM\\Mapping\\ClassMetadata');

        // Let's bind instances together.
        if (!$accessTokenRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $accessTokenRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$accessTokenRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $accessTokenRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata);
        }
        if (!$authCodeRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $authCodeRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$authCodeRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $authCodeRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata2);
        }
        if (!$clientRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $clientRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$clientRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $clientRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata3);
        }
        if (!$refreshTokenRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $refreshTokenRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$refreshTokenRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $refreshTokenRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata4);
        }
        if (!$scopeRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $scopeRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$scopeRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $scopeRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata5);
        }
        if (!$sessionRepository->getConstructorArgumentProperty('em')->isValueSet()) {
            $sessionRepository->getConstructorArgumentProperty('em')->setValue($entityManager);
        }
        if (!$sessionRepository->getConstructorArgumentProperty('class')->isValueSet()) {
            $sessionRepository->getConstructorArgumentProperty('class')->setValue($anonymousClassMetadata6);
        }
        $anonymousClassMetadata->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\AccessToken');
        $anonymousClassMetadata2->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\AuthCode');
        $anonymousClassMetadata3->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\Client');
        $anonymousClassMetadata4->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\RefreshToken');
        $anonymousClassMetadata5->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\Scope');
        $anonymousClassMetadata6->getConstructorArgumentProperty('entityName')->setValue('Mouf\\OAuthServer\\Model\\Entities\\Session');

        $moufManager->rewriteMouf();
    }
}
