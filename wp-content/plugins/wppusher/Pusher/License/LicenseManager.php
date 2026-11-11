<?php

namespace Pusher\License;

class LicenseManager
{
    /**
     * @var LicenseApi
     */
    private $client;

    /**
     * @var LicenseStatusCache
     */
    private $statusCache;

    /**
     * @param LicenseApi $client
     * @param LicenseStatusCache $statusCache
     */
    public function __construct(LicenseApi $client, LicenseStatusCache $statusCache)
    {
        $this->client = $client;
        $this->statusCache = $statusCache;
    }

    public function licenseKey()
    {
        $key = get_option('wppusher_license_key', false);

        if ( ! $key) {
            return false;
        }

        $key = $this->client->getLicenseKey($key);

        return $key;
    }

    public function activateSiteLicense($key, $oldKey)
    {
        // Field is deactivated, this means we
        // want to revoke it, since it can't be activated twice.
        $deactivate = is_null($key);

        // The cached status belongs to the old key. Drop it either way, so the daily
        // check starts again from nothing rather than judging the new key by the old
        // one's answer.
        $this->statusCache->forget();

        if ($deactivate) {
            return $this->client->removeLicenseFomSite($oldKey);
        }

        $isValid = $this->client->registerKeyForSite($key);

        if ( ! $isValid) {
            add_settings_error('invalid-license-key', '', 'WP Pusher license could not be activated.');
        }

        return $isValid;
    }
}
