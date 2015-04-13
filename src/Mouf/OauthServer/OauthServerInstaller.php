<?php
namespace Mouf\OauthServer;

use Mouf\Doctrine\ORM\Admin\DoctrineInstallUtils;
use Mouf\Installer\PackageInstallerInterface;
use Mouf\MoufManager;

class OauthServerInstaller implements PackageInstallerInterface {

    /**
     * (non-PHPdoc)
     * @see \Mouf\Installer\PackageInstallerInterface::install()
     */
    public static function install(MoufManager $moufManager) {
        $doctrineInstallUtils = new DoctrineInstallUtils($moufManager);

        $doctrineInstallUtils->registerAnnotationBasedEntities('Mouf\\OauthServer\\Model\\Entities', 'vendor/mouf/oauth2-server/src/Mouf/OauthServer/Model/Entities');

        // Let's rewrite the MoufComponents.php file to save the component
        $moufManager->rewriteMouf();
    }
}
