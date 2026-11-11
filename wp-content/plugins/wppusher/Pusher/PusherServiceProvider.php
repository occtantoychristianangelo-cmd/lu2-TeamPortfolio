<?php

namespace Pusher;

use Pusher\Log\Logger;

class PusherServiceProvider implements ProviderInterface
{
    public function register(Pusher $pusher)
    {
        // Bind the Pusher instance itself to the container
        $pusher->bind('Pusher\Pusher', $pusher);

        // Initialise logger from log file
        $pusher->bind('Pusher\Log\Logger', function(Pusher $pusher) {
            $log = Logger::file(trailingslashit($pusher->pusherPath) . 'pusherlog');
            return $log;
        });

        // The deploy lock (#180) needs an atomic create-if-absent. Only the database
        // gives it one on a stock install: see OptionDeployLockStore.
        $pusher->bind('Pusher\Storage\DeployLockStore', 'Pusher\Storage\OptionDeployLockStore');

        // Use EDD for licensing
        $pusher->bind('Pusher\License\LicenseApi', 'Pusher\License\DashboardLicenseApi');
        $pusher->bind('Pusher\License\LicenseStatusApi', 'Pusher\License\DashboardLicenseApi');

        // Singletons must be last for now, since they call "make()"
        $pusher->singleton('Pusher\Dashboard', 'Pusher\Dashboard');
    }
}
