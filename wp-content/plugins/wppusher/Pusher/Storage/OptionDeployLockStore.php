<?php

namespace Pusher\Storage;

/**
 * The deploy lock's row in wp_options, written with a single INSERT.
 *
 * The whole point of the lock is that two requests arriving in the same second cannot
 * both conclude the package is free, so the store has to be atomic on a stock
 * WordPress install. Most of the obvious candidates are not:
 *
 * - add_option() looks like it: it refuses when the option exists. But it decides that
 *   by reading the option first and writing afterwards, and the write itself is an
 *   INSERT ... ON DUPLICATE KEY UPDATE. Two requests both read "not there" and both
 *   write. That is the race this class exists to close.
 * - Transients are the same read-then-write one layer up.
 * - wp_cache_add() is atomic only where a persistent object cache backs it. The default
 *   install has none, so wp_cache_add() is an array in the current PHP process and two
 *   concurrent requests never see each other's entries at all. The default install is
 *   precisely the case that must work.
 *
 * What is left is the database, which is the only thing two PHP processes on a stock
 * install genuinely share. wp_options has a UNIQUE KEY on option_name, so of two
 * concurrent INSERTs of the same option_name MySQL accepts exactly one - the unique
 * index does the serialising, in the storage engine, with no window between the check
 * and the write. INSERT IGNORE turns the loser's duplicate-key error into "zero rows
 * affected", which is how the two outcomes are told apart without raising a PHP error.
 * WordPress core's own WP_Upgrader::create_lock() is built the same way.
 */
class OptionDeployLockStore implements DeployLockStore
{
    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    public function add($name, $value)
    {
        global $wpdb;

        $inserted = $wpdb->query($wpdb->prepare(
            "INSERT IGNORE INTO {$wpdb->options} (option_name, option_value, autoload) VALUES (%s, %s, 'no')",
            $name,
            $value
        ));

        // false is the query failing, 0 is the row already being there. Reading the
        // first as the second would turn a broken database into "a deploy is already
        // running", and Push-to-Deploy would stop for good.
        if ($inserted === false) {
            return self::FAILED;
        }

        return ($inserted > 0) ? self::ADDED : self::EXISTS;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function read($name)
    {
        global $wpdb;

        // Deliberately not get_option(): the row is written behind WordPress's back, so
        // the options cache can still be holding a "this option does not exist" entry
        // from earlier in the same request.
        $value = $wpdb->get_var($wpdb->prepare(
            "SELECT option_value FROM {$wpdb->options} WHERE option_name = %s",
            $name
        ));

        return is_null($value) ? null : (string) $value;
    }

    /**
     * @param string $name
     * @return void
     */
    public function remove($name)
    {
        // delete_option() rather than a DELETE, so the options caches are cleaned up
        // with the row. It reads the row straight from the database first, so the stale
        // cache entry above cannot make it skip the delete.
        delete_option($name);
    }
}
