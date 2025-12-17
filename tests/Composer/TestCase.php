<?php

namespace Moodle\Composer\Test;

use Composer\Composer;
use Composer\Config;
use Composer\Downloader\DownloadManager;
use Composer\Installer\InstallationManager;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Package\Version\VersionParser;
use Composer\Repository\RepositoryManager;
use Composer\Util\HttpDownloader;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var ?VersionParser */
    private static $parser = null;

    protected function getComposer(): Composer
    {
        $composer = new Composer();

        $composer->setPackage($pkg = new RootPackage('moodle/seed', '1.0.0.0', '1.0.0'));

        $composer->setConfig(new Config(false));

        $downloadManager = $this->getMockBuilder(DownloadManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $composer->setDownloadManager($downloadManager);

        $installationManager = $this->getMockBuilder(InstallationManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $composer->setInstallationManager($installationManager);

        $repositoryManager = new RepositoryManager(
            $this->getMockIO(),
            $composer->getConfig(),
            $this->getMockBuilder(HttpDownloader::class)->disableOriginalConstructor()->getMock()
        );
        $composer->setRepositoryManager($repositoryManager);

        return $composer;
    }

    protected function getMockIO(): \Composer\IO\IOInterface
    {
        return $this->getMockBuilder(\Composer\IO\IOInterface::class)
            ->getMock();
    }

    protected function getPackage(string $name, string $version): Package
    {
        $normVersion = self::getVersionParser()->normalize($version);

        return new Package($name, $normVersion, $version);
    }

    protected static function getVersionParser(): VersionParser
    {
        if (!self::$parser) {
            self::$parser = new VersionParser();
        }

        return self::$parser;
    }
}
