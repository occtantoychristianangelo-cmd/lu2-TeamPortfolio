<?php

namespace Pusher\WordPress;

/**
 * The bodies of the two `http_request_args` filters registered in wppusher.php.
 *
 * WP Pusher-managed plugins and themes must not be announced to
 * api.wordpress.org, or wordpress.org offers its own (unrelated) package as an
 * update for them. That stripping used to live in two closures in the plugin
 * bootstrap, where nothing could reach it: wppusher.php cannot be loaded outside
 * WordPress, so the code that runs on every single update check had no tests.
 *
 * It runs on every update check on every site we ship to, and in 3.0.15 it was
 * throwing an uncaught TypeError out of array_search() and taking sites down
 * (18 reporters). That is the code that most deserves a test, so it lives here
 * now. The URL matching and the repository lookups stay in wppusher.php.
 *
 * The array surgery moved across as-is apart from the guards that close what was
 * left of that fatal: `is_array($args['body'])` (the filter intercepts every caller
 * of the update URL, some of which pass a string body - indexing a string offset is
 * itself a PHP 8 fatal), `is_array($plugins)` (a body that isn't JSON decodes to
 * null, and unsetting an offset on a non-array is a fatal) and `is_array($plugins['active'])`
 * (isset() is true for a string, and array_search() on a string haystack is the same
 * TypeError 3.0.16 set out to fix).
 */
class UpdateCheckFilter
{
    /**
     * Remove WP Pusher-managed plugins from a plugins update-check request body.
     *
     * @param array $args           the `http_request_args` filter payload
     * @param array $pluginsToHide  plugin basenames, e.g. `my-plugin/my-plugin.php`
     *
     * @return array
     */
    public static function hidePlugins($args, array $pluginsToHide)
    {
        // This filter runs at priority 5 on `http_request_args`, so it intercepts every
        // caller of the update-check URL - not just WordPress core. A caller that passes
        // a string body would fatal on the offset access below (indexing a string offset
        // is a TypeError on PHP 8), the same failure class 3.0.16 fixed. Bail on a
        // non-array body and hand the request back untouched.
        if ( ! is_array($args['body'])) {
            return $args;
        }

        $plugins = json_decode($args['body']['plugins'], true);

        if ( ! is_array($plugins)) {
            return $args;
        }

        foreach ($pluginsToHide as $plugin) {
            unset($plugins['plugins'][$plugin]);

            // WordPress sends `active` as a list of basenames, but a site with a
            // corrupted or filtered payload can send anything at all. Passing a
            // non-array to array_search() is a fatal on PHP 8, and this filter runs
            // on every update check - so check the shape, don't assume it.
            if (isset($plugins['active']) and is_array($plugins['active'])) {
                $key = array_search($plugin, $plugins['active']);

                if ($key !== false) {
                    unset($plugins['active'][$key]);

                    // Re-index so `active` still serializes as a JSON array. Without
                    // this, unsetting a non-last element leaves a hole and json_encode
                    // emits an object ({"0":..,"2":..}) instead of a list. wp.org
                    // tolerates it, but the body should keep the shape core sent.
                    $plugins['active'] = array_values($plugins['active']);
                }
            }
        }

        $args['body']['plugins'] = json_encode($plugins);

        return $args;
    }

    /**
     * Remove WP Pusher-managed themes from a themes update-check request body.
     *
     * @param array $args          the `http_request_args` filter payload
     * @param array $themesToHide  theme stylesheet directory names
     *
     * @return array
     */
    public static function hideThemes($args, array $themesToHide)
    {
        // See hidePlugins(): a string body would fatal on the offset access below.
        if ( ! is_array($args['body'])) {
            return $args;
        }

        $themes = json_decode($args['body']['themes'], true);

        if ( ! is_array($themes)) {
            return $args;
        }

        foreach ($themesToHide as $theme) {
            unset($themes['themes'][$theme]);

            // `active` is a single stylesheet name here, not a list.
            if (isset($themes['active']) and in_array($themes['active'], $themesToHide)) {
                unset($themes['active']);
            }
        }

        $args['body']['themes'] = json_encode($themes);

        return $args;
    }
}
