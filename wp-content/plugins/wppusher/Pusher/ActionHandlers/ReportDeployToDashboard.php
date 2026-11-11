<?php

namespace Pusher\ActionHandlers;

use Pusher\Actions\PluginWasInstalled;
use Pusher\Actions\PluginWasUpdated;
use Pusher\Actions\ThemeWasInstalled;
use Pusher\Actions\ThemeWasUpdated;
use Pusher\Services\DeployReporter;

/**
 * Report a finished deploy to the WP Pusher dashboard (Agent API, plugin issue #177).
 *
 * One handler for all four deploy actions rather than the four single-action classes
 * the log/notice handlers use: the body would be identical in each, and the actions
 * carry no shared base class to type hint against.
 */
class ReportDeployToDashboard
{
    /**
     * @var DeployReporter
     */
    private $reporter;

    /**
     * @param DeployReporter $reporter
     */
    public function __construct(DeployReporter $reporter)
    {
        $this->reporter = $reporter;
    }

    public function handle($action)
    {
        if ($action instanceof PluginWasInstalled or $action instanceof PluginWasUpdated) {
            $this->reporter->reportPlugin($action->plugin);

            return;
        }

        if ($action instanceof ThemeWasInstalled or $action instanceof ThemeWasUpdated) {
            $this->reporter->reportTheme($action->theme);
        }
    }
}
