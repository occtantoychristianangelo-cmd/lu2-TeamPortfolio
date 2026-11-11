<?php

namespace Pusher\License;

/**
 * The one place that answers "may this site deploy a private repository?".
 *
 * Only private packages are gated. Public repositories are the free tier and keep
 * working whatever the license says. Nothing here ever deletes or deactivates an
 * installed package - enforcement stops the *next* deploy, it does not touch what is
 * already on the site.
 */
class LicenseGate
{
    /**
     * @var LicenseStatusCache
     */
    private $cache;

    /**
     * @param LicenseStatusCache $cache
     */
    public function __construct(LicenseStatusCache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return LicenseStatus
     */
    public function status()
    {
        return $this->cache->current();
    }

    /**
     * @return bool
     */
    public function allowsPrivateRepositories()
    {
        return $this->status()->allowsPrivateRepositories();
    }

    /**
     * Called by everything that is about to reach into a private repository.
     *
     * @throws LicenseExpired
     */
    public function guardPrivateRepositories()
    {
        $status = $this->status();

        if ($status->allowsPrivateRepositories()) {
            return;
        }

        throw new LicenseExpired($status->message());
    }

    /**
     * Should the admin see a notice about the license? True while it is lapsed, and
     * during the grace period, where everything still works but the deadline matters.
     *
     * @return bool
     */
    public function shouldNagAdmin()
    {
        $status = $this->status();

        return $status->isInGrace() or ! $status->allowsPrivateRepositories();
    }
}
