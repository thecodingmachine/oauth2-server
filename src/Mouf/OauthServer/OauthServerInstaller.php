<?php
namespace Mouf\OauthServer;

use Mouf\Installer\PackageInstallerInterface;
use Mouf\MoufManager;

class OauthServerInstaller implements PackageInstallerInterface {

    /**
     * (non-PHPdoc)
     * @see \Mouf\Installer\PackageInstallerInterface::install()
     */
    public static function install(MoufManager $moufManager) {
        $doctrineInstallUtils = new DoctrineInstallUtils($moufManager);

        $doctrineInstallUtils->registerYamlBasedEntities('League\\OAuth2\\Server\\Entity', 'vendor/mouf/oauth2-server/mapping/');

        // Let's rewrite the MoufComponents.php file to save the component
        $moufManager->rewriteMouf();
    }
}
