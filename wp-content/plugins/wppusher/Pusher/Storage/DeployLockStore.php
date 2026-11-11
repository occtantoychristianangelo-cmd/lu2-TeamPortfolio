<?php

namespace Pusher\Storage;

/**
 * The one atomic operation the deploy lock is built on: create this row, but only if
 * nobody else got there first.
 *
 * It is an interface so DeployLock's own rules - contention, expiry, failing open -
 * can be tested without a database, the way the license tests fake LicenseStatusApi.
 * The database implementation is OptionDeployLockStore.
 */
interface DeployLockStore
{
    /** There was no row and this caller created it. The caller holds the lock. */
    const ADDED = 'added';

    /** The row was already there. Somebody else holds the lock. */
    const EXISTS = 'exists';

    /** The store itself failed. Nothing at all can be concluded about the lock. */
    const FAILED = 'failed';

    /**
     * Atomically create $name, or report that it already exists.
     *
     * @param string $name
     * @param string $value
     * @return string one of ADDED, EXISTS or FAILED
     */
    public function add($name, $value);

    /**
     * @param string $name
     * @return string|null the stored value, or null when there is no row
     */
    public function read($name);

    /**
     * @param string $name
     * @return void
     */
    public function remove($name);
}
