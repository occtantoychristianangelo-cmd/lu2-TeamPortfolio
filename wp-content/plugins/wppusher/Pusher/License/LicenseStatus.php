<?php

namespace Pusher\License;

/**
 * What the license server last told us about the license on this site.
 *
 * This is a value object on purpose: no WordPress, no HTTP, no options. The cache
 * around it (LicenseStatusCache) does the talking; this decides what the answer
 * means. Everything unknown allows - a licensing outage must never stop a deploy.
 */
class LicenseStatus
{
    const ACTIVE = 'active';
    const GRACE = 'grace';
    const EXPIRED = 'expired';
    const REVOKED = 'revoked';
    const UNKNOWN = 'unknown';

    const BILLING_URL = 'https://dashboard.wppusher.com/dashboard/billing';

    /**
     * @var string
     */
    private $status;

    /**
     * @var string|null Whatever the server sent as the expiry date.
     */
    private $expires;

    /**
     * @var string|null End of the grace period, when the server sends one.
     */
    private $graceUntil;

    /**
     * @var int|null Unix time of the last check *attempt*, successful or not.
     */
    private $checkedAt;

    /**
     * @var bool Has the account switched deploy reporting on? See parseDeployReports().
     */
    private $deployReports;

    /**
     * @param string $status
     * @param string|null $expires
     * @param string|null $graceUntil
     * @param int|null $checkedAt
     * @param mixed $deployReports
     */
    public function __construct($status, $expires = null, $graceUntil = null, $checkedAt = null, $deployReports = false)
    {
        $this->status = in_array($status, self::knownStatuses(), true) ? $status : self::UNKNOWN;
        $this->expires = $expires;
        $this->graceUntil = $graceUntil;
        $this->checkedAt = is_null($checkedAt) ? null : (int) $checkedAt;
        $this->deployReports = self::parseDeployReports($deployReports);
    }

    /**
     * Nothing cached (or something unreadable cached). Behave as the plugin did
     * before enforcement existed: allow.
     *
     * @return LicenseStatus
     */
    public static function unknown()
    {
        return new self(self::UNKNOWN);
    }

    /**
     * @return array
     */
    public static function knownStatuses()
    {
        return array(self::ACTIVE, self::GRACE, self::EXPIRED, self::REVOKED, self::UNKNOWN);
    }

    /**
     * Rebuild from the wppusher_license_status option.
     *
     * @param array $array
     * @return LicenseStatus
     */
    public static function fromArray(array $array)
    {
        return new self(
            isset($array['status']) ? $array['status'] : self::UNKNOWN,
            isset($array['expires']) ? $array['expires'] : null,
            isset($array['grace_until']) ? $array['grace_until'] : null,
            isset($array['checked_at']) ? $array['checked_at'] : null,
            isset($array['deploy_reports']) ? $array['deploy_reports'] : false
        );
    }

    /**
     * Read a reply from GET /api/license-keys/{key}.
     *
     * The `status` field is what the backend is adding (companion issue). Until it
     * ships, an expiry date in the past is the only thing we can go on; anything
     * else - a lifetime license, a reply we do not recognise - is unknown, and
     * unknown allows.
     *
     * @param array $response
     * @param int|null $checkedAt
     * @return LicenseStatus
     */
    public static function fromResponseArray(array $response, $checkedAt = null)
    {
        $checkedAt = is_null($checkedAt) ? time() : (int) $checkedAt;

        $expires = isset($response['expires']) ? $response['expires'] : null;
        $graceUntil = isset($response['grace_until']) ? $response['grace_until'] : null;

        $status = isset($response['status']) && is_string($response['status'])
            ? strtolower(trim($response['status']))
            : null;

        if ( ! in_array($status, self::knownStatuses(), true)) {
            $status = self::deriveStatusFromExpiry($expires, $checkedAt);
        }

        $deployReports = isset($response['deploy_reports']) ? $response['deploy_reports'] : false;

        return new self($status, $expires, $graceUntil, $checkedAt, $deployReports);
    }

    /**
     * Read the deploy-reports flag, and note that this rule runs the opposite way
     * from the one directly below it. The two live next to each other on purpose:
     * the inconsistency is deliberate, so do not "fix" it.
     *
     * `status` fails OPEN. An absent, null or unreadable status is UNKNOWN, and
     * UNKNOWN allows, because a licensing outage must never block a deploy (#188).
     *
     * `deploy_reports` fails CLOSED. An absent, null or unreadable flag is off,
     * because an unknown must never start sending data the customer did not ask for
     * (#189, owner ruling 2026-09-17). Until the backend ships the field it will be
     * absent on every reply, and reporting stays off. That is the correct state.
     *
     * @param mixed $value
     * @return bool
     */
    private static function parseDeployReports($value)
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            return $value === 1;
        }

        if (is_string($value)) {
            return in_array(strtolower(trim($value)), array('1', 'true', 'yes'), true);
        }

        return false;
    }

    /**
     * @param string|null $expires
     * @param int $now
     * @return string
     */
    private static function deriveStatusFromExpiry($expires, $now)
    {
        if ( ! is_string($expires) or trim($expires) === '') {
            // No expiry date at all: a lifetime key, or a reply shaped differently
            // than we expect. Either way, not something to block a deploy over.
            return self::UNKNOWN;
        }

        $timestamp = strtotime($expires);

        if ($timestamp === false) {
            return self::UNKNOWN;
        }

        return $timestamp < $now ? self::EXPIRED : self::ACTIVE;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'status' => $this->status,
            'expires' => $this->expires,
            'grace_until' => $this->graceUntil,
            'checked_at' => $this->checkedAt,
            'deploy_reports' => $this->deployReports,
        );
    }

    /**
     * Same answer, new attempt timestamp. Used when a check fails: we keep what we
     * knew, but we do not re-ask on every request while the server is down.
     *
     * @param int $checkedAt
     * @return LicenseStatus
     */
    public function withCheckedAt($checkedAt)
    {
        return new self($this->status, $this->expires, $this->graceUntil, $checkedAt, $this->deployReports);
    }

    /**
     * @return string
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function expires()
    {
        return $this->expires;
    }

    /**
     * @return string|null
     */
    public function graceUntil()
    {
        return $this->graceUntil;
    }

    /**
     * @return int|null
     */
    public function checkedAt()
    {
        return $this->checkedAt;
    }

    /**
     * Has the account switched deploy reporting on - by creating an Agent API key on
     * the dashboard, or by toggling it there? Off unless the server said otherwise;
     * parseDeployReports() has the reasoning.
     *
     * @return bool
     */
    public function enablesDeployReports()
    {
        return $this->deployReports;
    }

    /**
     * @return bool
     */
    public function isInGrace()
    {
        return $this->status === self::GRACE;
    }

    /**
     * The gate. Note that unknown is on the allowing side.
     *
     * @return bool
     */
    public function allowsPrivateRepositories()
    {
        return ! in_array($this->status, array(self::EXPIRED, self::REVOKED), true);
    }

    /**
     * @param int $ttl
     * @param int|null $now
     * @return bool
     */
    public function isStale($ttl, $now = null)
    {
        if (is_null($this->checkedAt)) {
            return true;
        }

        $now = is_null($now) ? time() : (int) $now;

        return ($now - $this->checkedAt) >= $ttl;
    }

    /**
     * The sentence a site owner sees when a deploy is refused. Plain text - it goes
     * into exception messages and the log as well as the admin notice.
     *
     * @return string
     */
    public function message()
    {
        return sprintf(
            '%s Reactivate at %s to keep deploying private repositories.',
            $this->headline(),
            self::BILLING_URL
        );
    }

    /**
     * The message without the "reactivate at <url>" tail, for places that render the
     * link themselves.
     *
     * @return string
     */
    public function headline()
    {
        $expiryDate = $this->formatDate($this->expires);

        if ($this->status === self::GRACE) {
            $graceDate = $this->formatDate($this->graceUntil);

            return $graceDate
                ? "Your WP Pusher license has lapsed. Private repositories keep working until {$graceDate}."
                : 'Your WP Pusher license has lapsed and is in its grace period.';
        }

        if ($this->status === self::REVOKED) {
            return 'Your WP Pusher license is no longer active.';
        }

        return $expiryDate
            ? "Your WP Pusher license expired on {$expiryDate}."
            : 'Your WP Pusher license has expired.';
    }

    /**
     * @param string|null $date
     * @return string|null
     */
    private function formatDate($date)
    {
        if ( ! is_string($date) or trim($date) === '') {
            return null;
        }

        $timestamp = strtotime($date);

        if ($timestamp === false) {
            return null;
        }

        return date('F j, Y', $timestamp);
    }
}
