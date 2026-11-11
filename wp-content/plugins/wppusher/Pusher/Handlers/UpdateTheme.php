<?php

namespace Pusher\Handlers;

use Pusher\Actions\ThemeWasUpdated;
use Pusher\Commands\UpdateTheme as UpdateThemeCommand;
use Pusher\License\LicenseGate;
use Pusher\Storage\DeployLock;
use Pusher\Storage\ThemeRepository;
use Pusher\WordPress\ThemeUpgrader;

class UpdateTheme
{
    /**
     * @var ThemeRepository
     */
    private $themes;

    /**
     * @var ThemeUpgrader
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
     * @param ThemeRepository $themes
     * @param ThemeUpgrader $upgrader
     * @param LicenseGate $licenseGate
     * @param DeployLock $lock
     */
    public function __construct(ThemeRepository $themes, ThemeUpgrader $upgrader, LicenseGate $licenseGate, DeployLock $lock)
    {
        $this->themes = $themes;
        $this->upgrader = $upgrader;
        $this->licenseGate = $licenseGate;
        $this->lock = $lock;
    }

    public function handle(UpdateThemeCommand $command)
    {
        $theme = $this->themes->pusherThemeFromStylesheet($command->stylesheet);

        // Push-to-Deploy runs through this handler too, so this one check covers both
        // the update button and the webhook. Public packages are never gated.
        if ($theme->getRepository()->isPrivate()) {
            $this->licenseGate->guardPrivateRepositories();
        }

        // One deploy of this theme at a time (#180). See the note in the plugin
        // handler - Push-to-Deploy and the update button both come through here.
        $this->lock->protect("theme {$theme->getIdentifier()}", function () use ($theme) {
            $this->upgrader->upgradeTheme($theme);

            $theme->setDeployedCommit($this->upgrader->getDeployedCommit());

            do_action('wppusher_theme_was_updated', new ThemeWasUpdated($theme));
        });
    }
}
