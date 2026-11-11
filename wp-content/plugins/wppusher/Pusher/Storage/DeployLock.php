<?php

namespace Pusher\Storage;

use Pusher\Log\Logger;

/**
 * One deploy of a package at a time (#180).
 *
 * Two Push-to-Deploy deliveries for the same package landing in the same second used
 * to run side by side. An update replaces the package directory, so the second run
 * deleted or overwrote the tree the first one was halfway through writing, and the
 * package was left broken, deactivated or gone.
 *
 * The lock is per package, not global: two different packages deploying at once is
 * normal and stays allowed. Only a second deploy of the *same* package is stopped, and
 * it is dropped rather than queued - it is a duplicate of the deploy already running,
 * against the same commit, so running it afterwards would achieve nothing but another
 * download.
 *
 * Two deliberate asymmetries, both of them about not making things worse:
 *
 * - It fails CLOSED on contention. Somebody holds the lock, so this deploy does not
 *   run. That is the fix.
 * - It fails OPEN on its own errors. If the lock cannot be taken because the store
 *   broke, the deploy goes ahead unprotected. A rare race is a bad day; a lock that
 *   answers "no" forever is Push-to-Deploy silently never working again.
 *
 * And it cannot deadlock: the lock carries the time it was taken, and any deploy that
 * finds one older than TIMEOUT breaks it. A PHP process killed mid-install - a fatal,
 * an execution timeout, an OOM - releases nothing, so something has to.
 */
class DeployLock
{
    /**
     * How long a lock may be held before the next deploy is allowed to break it.
     *
     * 15 minutes. It has to be longer than the slowest realistic deploy, and a deploy
     * cannot outlive the PHP process running it: hosts cap max_execution_time in the
     * 30-300 second range and web servers give up long before 15 minutes. So a lock
     * this old belongs to a process that is not coming back. It also has to be short
     * enough that an orphaned lock costs a push or two rather than an afternoon, which
     * rules out core's one-hour WP_Upgrader lock.
     */
    const TIMEOUT = 900;

    /**
     * Option names are limited to 191 characters and a package identifier is arbitrary
     * text, so the identifier is hashed rather than appended. The readable name goes in
     * the log line instead.
     */
    const PREFIX = 'wppusher_deploy_lock_';

    /**
     * @var DeployLockStore
     */
    private $store;

    /**
     * @var Logger
     */
    private $log;

    /**
     * @param DeployLockStore $store
     * @param Logger $log
     */
    public function __construct(DeployLockStore $store, Logger $log)
    {
        $this->store = $store;
        $this->log = $log;
    }

    /**
     * Run $deploy with $package locked, unless another deploy of the same package is
     * already running, in which case do nothing.
     *
     * @param string $package human-readable package identifier, e.g. "plugin hello/hello.php"
     * @param callable $deploy
     * @return bool false when the deploy was skipped
     */
    public function protect($package, $deploy)
    {
        if ( ! $this->acquire($package)) {
            $this->log->warning("Skipped a deploy of {$package}. Another deploy of the same package is already running, and this one would have overwritten it halfway through. Nothing was changed.");

            return false;
        }

        try {
            call_user_func($deploy);
        } finally {
            $this->release($package);
        }

        return true;
    }

    /**
     * @param string $package
     * @return bool
     */
    public function acquire($package)
    {
        $name = $this->optionName($package);

        $result = $this->store->add($name, (string) time());

        if ($result === DeployLockStore::ADDED) {
            return true;
        }

        if ($result === DeployLockStore::FAILED) {
            $this->log->warning("Could not take the deploy lock for {$package}, so this deploy is running without it.");

            return true;
        }

        // Somebody holds it. Unless they have held it for longer than any deploy can
        // last, in which case take it off them - see TIMEOUT.
        if ( ! $this->hasExpired($this->store->read($name))) {
            return false;
        }

        $this->log->warning("Breaking a stale deploy lock for {$package}. The deploy holding it started more than " . (self::TIMEOUT / 60) . " minutes ago and never finished.");

        $this->store->remove($name);

        // Whoever else is breaking the same stale lock right now may win this, and if
        // they do, this deploy stands down exactly as it would for any other holder.
        return $this->store->add($name, (string) time()) === DeployLockStore::ADDED;
    }

    /**
     * @param string $package
     * @return void
     */
    public function release($package)
    {
        $this->store->remove($this->optionName($package));
    }

    /**
     * @param string|null $takenAt
     * @return bool
     */
    private function hasExpired($takenAt)
    {
        // No row - the holder finished between the INSERT and this read - or junk in
        // it. Either way there is nothing left to wait for, and the re-acquire that
        // follows still loses to a real holder rather than guessing.
        if ( ! is_numeric($takenAt)) {
            return true;
        }

        return (time() - (int) $takenAt) > self::TIMEOUT;
    }

    /**
     * @param string $package
     * @return string
     */
    private function optionName($package)
    {
        return self::PREFIX . md5($package);
    }
}
