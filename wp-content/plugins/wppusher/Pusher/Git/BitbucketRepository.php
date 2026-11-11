<?php

namespace Pusher\Git;

use Exception;
use Pusher\Log\Logger;
use Pusher\Pusher;

class BitbucketRepository extends Repository
{
    public $code = 'bb';

    const REFRESH_TOKEN_ENDPOINT = 'https://cloud.wppusher.com/auth/bitbucket/refresh-token';
    const MAX_TOKEN_EXCHANGE_ATTEMPTS = 2;
    const TOKEN_EXCHANGE_RETRY_DELAY_MS = 500;

    /**
     * Human-readable detail of the most recent token-exchange failure, if any.
     * Read by the upgrader skins to render an actionable error.
     *
     * @var string|null
     */
    public $lastAuthError = null;

    private $bearerToken = null;

    public function getZipUrl()
    {
        $url = 'https://bitbucket.org/' . $this->handle . '/get/' . $this->getBranch() . '.zip?dir=/wppusher';

        if ( ! $this->isPrivate()) {
            return $url;
        }

        $token = get_option('bb_token');

        if (is_string($token) and $token !== '') {
            try {
                $this->bearerToken = $this->getAccessTokenFromRefreshToken($token);
                add_filter('http_request_args', array($this, 'bitbucketBearerAuth'), 10, 2);
            } catch (BitbucketAuthExchangeFailed $e) {
                $this->lastAuthError = $e->getDetail();
            }

            return $url;
        }

        add_filter('http_request_args', array($this, 'bitbucketBasicAuth'), 10, 2 );

        return $url;
    }

    public function bitbucketBearerAuth($args, $url)
    {
        if ( ! strstr($url, 'https://bitbucket.org/'))
            return $args;

        $args['headers']['Authorization'] = 'Bearer ' . $this->bearerToken;

        return $args;
    }

    public function bitbucketBasicAuth($args, $url)
    {
        if ( ! strstr($url, 'https://bitbucket.org/'))
            return $args;

        $user = get_option('bb_user');
        $pass = get_option('bb_pass');

        if (is_string($user) && $user === '')
            throw new Exception('No Bitbucket username stored.');

        if (is_string($pass) && $pass === '')
            throw new Exception('No Bitbucket password stored.');

        $args['headers']['Authorization'] = 'Basic ' . base64_encode("{$user}:{$pass}");

        return $args;
    }

    /**
     * @throws BitbucketAuthExchangeFailed when all attempts fail.
     */
    public function getAccessTokenFromRefreshToken($token)
    {
        $logger = $this->getLogger();
        $lastStatus = null;
        $lastBody = '';
        $lastReason = 'unknown error';

        for ($attempt = 1; $attempt <= self::MAX_TOKEN_EXCHANGE_ATTEMPTS; $attempt++) {
            $response = wp_remote_get(self::REFRESH_TOKEN_ENDPOINT . '?refresh_token=' . urlencode($token));

            if (is_wp_error($response)) {
                $lastStatus = null;
                $lastBody = '';
                $lastReason = 'WP_Error: ' . $response->get_error_message();
            } elseif (empty($response)) {
                $lastStatus = null;
                $lastBody = '';
                $lastReason = 'empty response';
            } else {
                $lastStatus = wp_remote_retrieve_response_code($response);
                $lastBody = wp_remote_retrieve_body($response);

                if ($lastStatus === 200) {
                    $json = json_decode($lastBody, true);
                    if (isset($json['access_token']) && is_string($json['access_token']) && $json['access_token'] !== '') {
                        if ($attempt > 1 && $logger) {
                            $logger->info("Bitbucket token exchange succeeded on attempt {$attempt}.");
                        }
                        return $json['access_token'];
                    }
                    $lastReason = 'response missing access_token';
                } else {
                    $lastReason = "non-200 status";
                }
            }

            if ($logger) {
                $statusPart = $lastStatus === null ? 'no status' : "status {$lastStatus}";
                $logger->warning(
                    "Bitbucket token exchange failed (attempt {$attempt}/" . self::MAX_TOKEN_EXCHANGE_ATTEMPTS . "): {$lastReason} ({$statusPart})"
                );
            }

            $hasMoreAttempts = $attempt < self::MAX_TOKEN_EXCHANGE_ATTEMPTS;
            if ($hasMoreAttempts) {
                usleep(self::TOKEN_EXCHANGE_RETRY_DELAY_MS * 1000);
            }
        }

        $message = "Bitbucket token exchange failed: {$lastReason}";
        if ($logger) {
            $logger->error($message);
        }

        throw new BitbucketAuthExchangeFailed(
            $message,
            $lastStatus,
            $lastBody,
            self::MAX_TOKEN_EXCHANGE_ATTEMPTS
        );
    }

    private function getLogger()
    {
        $pusher = Pusher::getInstance();
        if ( ! $pusher) {
            return null;
        }

        try {
            return $pusher->make('Pusher\Log\Logger');
        } catch (Exception $e) {
            return null;
        }
    }
}
