<?php

/**
 * Plugin Name: WP Pusher
 * Plugin URI: http://wppusher.com
 * Description: Pain-free deployment of WordPress themes and plugins directly from GitHub.
 * Version: 3.0.20
 * Requires at least: 6.0
 * Requires PHP: 7.2
 * Author: WP Pusher
 * Author URI: http://wppusher.com
 * License: GNU GENERAL PUBLIC LICENSE
 */

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

require __DIR__ . '/autoload.php';

use Pusher\ActionHandlers\ActionHandlerProvider;
use Pusher\Pusher;
use Pusher\PusherServiceProvider;
use Pusher\WordPress\UpdateCheckFilter;

// WP Pusher's main class is the fully-qualified name Pusher\Pusher. A handful of other
// plugins declare a class with that exact name - most notably BuddyBoss, which bundles
// the pusher/pusher-php-server library (also Pusher\Pusher). PHP cannot hold two
// declarations of one class name: whichever plugin loads second dies with an uncatchable
// "Cannot declare class" fatal that white-screens the whole site. If the name is already
// taken by the time we boot, don't declare ours on top of it - show the admin an
// explanation and stop, so the site stays up.
//
// This is the cheap interim. The real fix is renaming our root namespace, which is a
// large, breaking change tracked separately (BuddyBoss collision, cluster E).
if (class_exists('Pusher\\Pusher', false)) {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p>'
            . '<strong>WP Pusher could not start.</strong> Another active plugin has already '
            . 'declared a <code>Pusher\\Pusher</code> PHP class (a known conflict with BuddyBoss '
            . 'and other plugins that bundle the Pusher library). WP Pusher has stopped itself to '
            . 'avoid a site-wide fatal error. Please deactivate the conflicting plugin, or contact '
            . '<a href="https://wppusher.com/support">WP Pusher support</a>.'
            . '</p></div>';
    });

    return;
}

$pusher = new Pusher;
$pusher->setInstance($pusher);
$pusher->pusherPath = plugin_dir_path(__FILE__);
$pusher->pusherUrl = plugin_dir_url(__FILE__);
$pusher->register(new PusherServiceProvider);
$pusher->register(new ActionHandlerProvider);

do_action('wppusher_register_dependency', $pusher);

register_activation_hook(__FILE__, array($pusher, 'activate'));

require_once('wp-updates-plugin.php');
new WPUpdatesPluginUpdater_957('https://dashboard.wppusher.com/api/releases/latest', plugin_basename(__FILE__));

$pusher->init();

if ( ! function_exists('getHostIcon')) {
    function getHostIcon($host)
    {
        if ($host === 'gh') {
            return 'fa-github';
        } elseif ($host === 'bb') {
            return 'fa-bitbucket';
        } else {
            return 'fa-gitlab';
        }
    }
}

if ( ! function_exists('getHostBaseUrl')) {
    function getHostBaseUrl($host)
    {
        if ($host === 'gh') {
            return 'https://github.com/';
        } elseif ($host === 'bb') {
            return 'https://bitbucket.org/';
        } elseif ($host === 'gl') {
            return trailingslashit(get_option('gl_base_url'));
        } else {
            return null;
        }
    }
}

$hidePluginsFromUpdateChecks = function($args, $url) use ($pusher)
{
    if (0 !== strpos($url, 'https://api.wordpress.org/plugins/update-check')) {
        return $args;
    }

    $repository = $pusher->make('Pusher\Storage\PluginRepository');
    $pluginsToHide = array_keys($repository->allPusherPlugins());
    $pluginsToHide[] = plugin_basename(__FILE__);

    return UpdateCheckFilter::hidePlugins($args, $pluginsToHide);
};

$hideThemesFromUpdateChecks = function($args, $url) use ($pusher)
{
    if (0 !== strpos($url, 'https://api.wordpress.org/themes/update-check')) {
        return $args;
    }

    $repository = $pusher->make('Pusher\Storage\ThemeRepository');
    $themesToHide = array_keys($repository->allPusherThemes());

    return UpdateCheckFilter::hideThemes($args, $themesToHide);
};

add_filter('http_request_args', $hidePluginsFromUpdateChecks, 5, 2);
add_filter('http_request_args', $hideThemesFromUpdateChecks, 5, 2);

// Add link to help page
add_action('admin_menu', function () {
    global $submenu;

    if (current_user_can('manage_options')) {
        $submenu['wppusher'][] = array('Get Help', 'manage_options', 'https://wppusher.com/support');
    }
});

// Dismiss welcome hero. Hooked on admin_init rather than run while this file is being
// included: at include time pluggable.php has not loaded, so there is no current user to
// check, and the option was being written for anybody who requested the URL - logged out
// visitors included.
add_action('admin_init', function () {
    if ( ! isset($_GET['wppusher-welcome']) or sanitize_key(wp_unslash($_GET['wppusher-welcome'])) !== '0') {
        return;
    }

    if ( ! current_user_can('update_plugins')) {
        return;
    }

    $nonce = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

    // Silently ignore a stale link rather than showing WordPress' "link expired" screen:
    // this only hides a welcome panel, and the panel simply stays put.
    if ( ! wp_verify_nonce($nonce, 'wppusher-dismiss-welcome')) {
        return;
    }

    update_option('hide-wppusher-welcome', true);
});

if ( ! function_exists('pusherTableName()')) {
    function pusherTableName()
    {
        global $wpdb;
        $dbPrefix = is_multisite() ? $wpdb->base_prefix : $wpdb->prefix;

        return $dbPrefix . 'wppusher_packages';
    }
}

if ( ! function_exists('pusher')) {
    /**
     * @return \Pusher\Pusher
     */
    function pusher() {
        return \Pusher\Pusher::getInstance();
    }
}
