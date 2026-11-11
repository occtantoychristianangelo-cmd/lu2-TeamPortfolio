<?php

namespace Pusher\Handlers;

use Pusher\Actions\PluginWasUpdated;
use Pusher\Commands\UpdatePlugin as UpdatePluginCommand;
use Pusher\License\LicenseGate;
use Pusher\Storage\DeployLock;
use Pusher\Storage\PluginRepository;
use Pusher\WordPress\PluginUpgrader;

class UpdatePlugin
{
    /**
     * @var PluginRepository
     */
    private $plugins;

    /**
     * @var PluginUpgrader
     */
    private $upgrader;

    /**
     * @var LicenseGate
     */
    private $licenseGate;

    /**
     * @var DeployLock
     */
    private $lock;

    /**
     * @param PluginRepository $plugins
     * @param PluginUpgrader $upgrader
     * @param LicenseGate $licenseGate
     * @param DeployLock $lock
     */
    public function __construct(PluginRepository $plugins, PluginUpgrader $upgrader, LicenseGate $licenseGate, DeployLock $lock)
    {
        $this->plugins = $plugins;
        $this->upgrader = $upgrader;
        $this->licenseGate = $licenseGate;
        $this->lock = $lock;
    }

    public function handle(UpdatePluginCommand $command)
    {
        $plugin = $this->plugins->pusherPluginFromFile($command->file);

        // Push-to-Deploy runs through this handler too, so this one check covers both
        // the update button and the webhook. Public packages are never gated.
        if ($plugin->getRepository()->isPrivate()) {
            $this->licenseGate->guardPrivateRepositories();
        }

        // One deploy of this plugin at a time (#180). Push-to-Deploy and the update
        // button both arrive here, so this covers a repository wired to two webhooks
        // and a double-clicked button alike. A second deploy of the same plugin while
        // one is running is a duplicate, and is dropped rather than left to overwrite
        // the directory the first one is still writing.
        $this->lock->protect("plugin {$plugin->getIdentifier()}", function () use ($plugin) {
            $this->upgrader->upgradePlugin($plugin);

            $plugin->setDeployedCommit($this->upgrader->getDeployedCommit());

            do_action('wppusher_plugin_was_updated', new PluginWasUpdated($plugin));
        });
    }
}
