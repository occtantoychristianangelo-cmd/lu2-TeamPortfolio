<?php

namespace Pusher\License;

use Pusher\Log\Logger;

/**
 * The daily cached license status, kept in the wppusher_license_status option.
 *
 * Deploys read the option and nothing else, so the license server is never in the
 * path of an install, an update or a Push-to-Deploy. A refresh happens at most once
 * a day (wp-cron, plus a catch-up on admin_init for sites with wp-cron disabled).
 *
 * Fail open, everywhere: if the server is unreachable or answers with junk, the last
 * known status stands. Only the check timestamp moves, so a licensing outage means
 * one failed request a day rather than one on every request.
 */
class LicenseStatusCache
{
    const OPTION = 'wppusher_license_status';

    const TTL = 86400;

    /**
     * @var LicenseStatusApi
     */
    private $api;

    /**
     * @var Logger
     */
    private $log;

    /**
     * @param LicenseStatusApi $api
     * @param Logger $log
     */
    public function __construct(LicenseStatusApi $api, Logger $log)
    {
        $this->api = $api;
        $this->log = $log;
    }

    /**
     * @return LicenseStatus
     */
    public function current()
    {
        return self::stored();
    }

    /**
     * The cached status, read straight out of the option.
     *
     * Static because the deploy reporter (#189) needs the deploy_reports flag from a
     * context that has no license API client to hand, and building one there would
     * only invite a refresh in the middle of a deploy. Reading never refreshes.
     *
     * @return LicenseStatus
     */
    public static function stored()
    {
        $stored = get_option(self::OPTION, false);

        if ( ! is_array($stored)) {
            return LicenseStatus::unknown();
        }

        return LicenseStatus::fromArray($stored);
    }

    /**
     * @return LicenseStatus
     */
    public function refreshIfStale()
    {
        $current = $this->current();

        if ( ! $current->isStale(self::TTL)) {
            return $current;
        }

        return $this->refresh();
    }

    /**
     * @return LicenseStatus
     */
    public function refresh()
    {
        $key = get_option('wppusher_license_key', false);

        if ( ! $key) {
            // No key on the site: nothing to ask about, and nothing to enforce.
            $this->forget();

            return LicenseStatus::unknown();
        }

        $response = $this->api->fetchLicenseStatus($key);

        if ( ! is_array($response)) {
            $this->log->error('Could not check the WP Pusher license status. Keeping the cached status.');

            return $this->keepCurrent();
        }

        $status = LicenseStatus::fromResponseArray($response);

        update_option(self::OPTION, $status->toArray());

        return $status;
    }

    public function forget()
    {
        delete_option(self::OPTION);
    }

    /**
     * A check was attempted and failed. Keep the answer, move the clock, so the next
     * attempt is a day away instead of on the next page load.
     *
     * @return LicenseStatus
     */
    private function keepCurrent()
    {
        $current = $this->current()->withCheckedAt(time());

        update_option(self::OPTION, $current->toArray());

        return $current;
    }
}
