<?php

namespace Pusher\License;

interface LicenseStatusApi
{
    /**
     * Ask the license server what this key's status is, without side effects - no
     * activation, no revocation, just a read.
     *
     * @param string $key
     * @return array|false The decoded reply, or false if we could not get one.
     */
    public function fetchLicenseStatus($key);
}
