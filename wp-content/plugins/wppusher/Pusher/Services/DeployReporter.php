<?php

namespace Pusher\Services;

use Pusher\License\LicenseStatusCache;
use Pusher\Plugin;
use Pusher\Storage\DeployRecords;
use Pusher\Storage\PluginRepository;
use Pusher\Storage\ThemeRepository;
use Pusher\Theme;

/**
 * Tells the WP Pusher dashboard what this site has deployed - the outbound half of the
 * WP Pusher Agent API (plugin issue #177, epic #174).
 *
 * Two messages, both fire-and-forget:
 *
 * - a deploy report, sent when a package is installed or updated, so the answer to
 *   "did my push reach the site" arrives immediately;
 * - the package table, sent on the same twice-daily cadence as the update check, so a
 *   report that was dropped (site offline, dashboard down) heals itself on the next
 *   heartbeat instead of leaving the dashboard permanently wrong.
 *
 * Nothing is sent from a site without a license key, exactly like the heartbeat added
 * in 3.0.16, and every request is non-blocking: a slow or unreachable dashboard must
 * never hold up a deploy.
 *
 * Both messages are off until the account switches them on, which it does by creating
 * an Agent API key on the dashboard (issue #189, owner ruling 2026-09-17). The answer
 * arrives on the daily license-status check and the checkbox on the license tab is a
 * per-site override on top of it that can force them back off. Neither message is
 * needed to verify the license, so the license check and the update check's
 * identification are not affected either way.
 */
class DeployReporter
{
    const DEPLOYS_ENDPOINT = 'https://dashboard.wppusher.com/api/sites/deploys';

    const PACKAGES_ENDPOINT = 'https://dashboard.wppusher.com/api/sites/packages';

    const HEARTBEAT_TRANSIENT = 'wppusher_packages_reported';

    /**
     * The license tab's checkbox. An absent option means "not unticked", not "on" -
     * on its own it never starts a site reporting. See siteAllowsReporting().
     */
    const REPORTING_OPTION = 'wppusher_deploy_reports';

    /**
     * Twelve hours - WordPress' own update-check interval, which is the hook this
     * rides on. The hook itself fires more often than that (every plugins screen can
     * trigger a check), so the interval is enforced here rather than assumed.
     */
    const HEARTBEAT_INTERVAL = 43200;

    /**
     * @var DeployRecords
     */
    private $records;

    /**
     * @var PluginRepository
     */
    private $plugins;

    /**
     * @var ThemeRepository
     */
    private $themes;

    /**
     * @param DeployRecords $records
     * @param PluginRepository $plugins
     * @param ThemeRepository $themes
     */
    public function __construct(DeployRecords $records, PluginRepository $plugins, ThemeRepository $themes)
    {
        $this->records = $records;
        $this->plugins = $plugins;
        $this->themes = $themes;
    }

    /**
     * @param Plugin $plugin
     */
    public function reportPlugin(Plugin $plugin)
    {
        $this->report($plugin, 'plugin');
    }

    /**
     * @param Theme $theme
     */
    public function reportTheme(Theme $theme)
    {
        $this->report($theme, 'theme');
    }

    /**
     * Is the site sending deploy reports and the package table at all? Read by the
     * license tab as well, so the rule lives in one place.
     *
     * Two gates, and both have to be open: the account has to have switched
     * reporting on, and this particular site must not have unticked the checkbox.
     *
     * @return bool
     */
    public static function reportingIsEnabled()
    {
        return self::serverEnablesReporting() && self::siteAllowsReporting();
    }

    /**
     * Has the account switched reporting on? That happens on the dashboard, by
     * creating an Agent API key; the answer rides back on the daily license-status
     * check that #188 already makes and caches, so there is no second network path
     * and a deploy never talks to the license server.
     *
     * Absent means off - LicenseStatus::parseDeployReports() has the reasoning, and
     * why it is deliberately the opposite of how the license status itself behaves.
     * The dashboard half has not shipped yet (backend #130), so in production the
     * field is absent on every reply and reporting stays off. That is the expected
     * state, not a bug.
     *
     * @return bool
     */
    public static function serverEnablesReporting()
    {
        return LicenseStatusCache::stored()->enablesDeployReports();
    }

    /**
     * The checkbox on the license tab: a per-site override that can only ever switch
     * reporting off. An explicit "0" - an unticked box - stops this site reporting
     * even when the account has it on. A ticked box does not switch anything on by
     * itself, which is why an absent option reads as "not unticked" rather than "on".
     *
     * @return bool
     */
    public static function siteAllowsReporting()
    {
        return get_option(self::REPORTING_OPTION, '1') != '0';
    }

    /**
     * The package table, sent at most once every HEARTBEAT_INTERVAL seconds.
     */
    public function reportPackages()
    {
        // Checked before the transient is set, not after: switching reporting back
        // on then sends the table on the next update check, rather than leaving the
        // dashboard stale for up to twelve hours.
        if ( ! self::reportingIsEnabled()) {
            return;
        }

        $licenseKey = get_option('wppusher_license_key');

        if ( ! $licenseKey) {
            return;
        }

        if (get_transient(self::HEARTBEAT_TRANSIENT)) {
            return;
        }

        // Set before sending, not after: the request is non-blocking, so there is no
        // outcome to wait for, and a failure must not turn into a send on every check.
        set_transient(self::HEARTBEAT_TRANSIENT, 1, self::HEARTBEAT_INTERVAL);

        $packages = array_merge(
            $this->describe($this->plugins->allPusherPlugins(), 'plugin'),
            $this->describe($this->themes->allPusherThemes(), 'theme')
        );

        if (empty($packages)) {
            return;
        }

        $this->post(self::PACKAGES_ENDPOINT, array(
            'license_key' => $licenseKey,
            'site_url' => home_url(),
            'packages' => $packages,
        ));
    }

    /**
     * Ride the update check, which is the heartbeat. This is a filter, not an action,
     * so the transient it is filtering has to come back out untouched.
     *
     * @param mixed $value
     * @return mixed
     */
    public function reportPackagesFilter($value)
    {
        $this->reportPackages();

        return $value;
    }

    /**
     * @param Plugin|Theme $package
     * @param string $type
     */
    private function report($package, $type)
    {
        $commit = $package->getDeployedCommit();
        $deployedAt = gmdate('c');

        // Recorded whether or not it can be sent: the record is what the heartbeat
        // reports later, and a site can be licensed after the deploy that installed it.
        $this->records->record($type, $package->getIdentifier(), $commit, $deployedAt);

        // Recorded above regardless, so the package table is right the moment
        // reporting goes back on.
        if ( ! self::reportingIsEnabled()) {
            return;
        }

        $licenseKey = get_option('wppusher_license_key');

        if ( ! $licenseKey) {
            return;
        }

        $this->post(self::DEPLOYS_ENDPOINT, array(
            'license_key' => $licenseKey,
            'site_url' => home_url(),
            'package' => $package->getIdentifier(),
            'type' => $type,
            'repository' => (string) $package->getRepository(),
            'branch' => $package->getRepository()->getBranch(),
            'commit' => $commit,
            'deployed_at' => $deployedAt,
        ));
    }

    /**
     * @param array $packages
     * @param string $type
     * @return array
     */
    private function describe(array $packages, $type)
    {
        $described = array();

        foreach ($packages as $package) {
            $record = $this->records->get($type, $package->getIdentifier());

            $described[] = array(
                'package' => $package->getIdentifier(),
                'type' => $type,
                'host' => $package->host,
                'repository' => (string) $package->getRepository(),
                'branch' => $package->getRepository()->getBranch(),
                'subdirectory' => $package->getSubdirectory(),
                'deployed_commit' => $record['commit'],
                'deployed_at' => $record['deployed_at'],
                'push_to_deploy' => (bool) $package->pushToDeploy,
            );
        }

        return $described;
    }

    /**
     * @param string $url
     * @param array $payload
     */
    private function post($url, array $payload)
    {
        // Lets a site - or the integration suite - point the reports somewhere else.
        $url = apply_filters('wppusher_dashboard_api_url', $url);

        wp_remote_post($url, array(
            'blocking' => false,
            'timeout' => 5,
            'headers' => array(
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ),
            'body' => wp_json_encode($payload),
        ));
    }
}
