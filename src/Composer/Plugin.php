<?php

namespace Moodle\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    /**
     * @var MoodleInstaller
     */
    private MoodleInstaller $_installer;

    /**
     * {@inheritDoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->_installer = new MoodleInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($this->_installer);
    }

    /**
     * {@inheritDoc}
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
        $composer->getInstallationManager()->removeInstaller($this->_installer);
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(Composer $composer, IOInterface $io)
    {
        // No action needed on uninstall.
    }
}
