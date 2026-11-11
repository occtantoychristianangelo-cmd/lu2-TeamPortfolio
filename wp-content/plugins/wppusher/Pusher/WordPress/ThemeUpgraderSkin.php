<?php

namespace Pusher\WordPress;

use Exception;
use Pusher\Actions\ThemeUpdateFailed;
use Pusher\Pusher;
use Theme_Upgrader_Skin;
use WP_Error;

class ThemeUpgraderSkin extends Theme_Upgrader_Skin
{
    protected $error;
    protected $feedback;

    public function after()
    {
        // WP doesn't sent all errors as actual error objects
        if ($this->error === 'up_to_date') {
            $this->error = new WP_Error('wppusher_error', 'Theme is up-to-date.');
        }

        if ($this->error instanceof WP_Error) {
            $code = $this->error->get_error_code();

            if ($code === 'download_failed') {
                $this->error = $this->decorateDownloadFailed($this->error);
            } elseif ($code === 'incompatible_archive') {
                $this->error = $this->decorateIncompatibleArchive($this->error);
            }
        }

        if ( ! is_null($this->error)) {
            $message = $this->error instanceof WP_Error
                ? $this->error->get_error_message()
                : (string) $this->error;

            do_action('wppusher_theme_update_failed', new ThemeUpdateFailed($message));

            throw new InstallFailed($message);
        }
    }

    private function decorateDownloadFailed(WP_Error $error)
    {
        $message = $error->get_error_message();
        $message .= $this->renderErrorData($error->get_error_data());

        $type = $this->getRepositoryCode();

        if ($type === 'gh') {
            $message .= '<p><strong>Common issues when using GitHub:</strong></p>';
            $message .= '<ul style="list-style: disc; padding-left: 1.2rem;"><li>The Git branch doesn\'t exist - GitHub now defaults to <code>main</code> instead of <code>master</code>.</li><li>Token has been invalidated, try obtaining <a href="admin.php?page=wppusher&tab=github">a new token</a>.</li><li>WP Pusher doesn\'t have access to the GitHub org - grant it <a href="https://github.com/settings/connections/applications/c48c02cdb49a43bb36b8" target="_blank">here</a> and issue <a href="admin.php?page=wppusher&tab=github">a new token</a>.</li><li>Repository handle is incorrect.</li></ul>';
        } elseif ($type === 'bb') {
            $message .= $this->renderBitbucketHint();
        }

        return new WP_Error('download_failed', $message);
    }

    private function decorateIncompatibleArchive(WP_Error $error)
    {
        $message = $error->get_error_message();
        $message .= $this->renderErrorData($error->get_error_data());
        $message .= $this->renderBitbucketAuthDetail();

        $type = $this->getRepositoryCode();

        if ($type === 'bb') {
            $message .= $this->renderBitbucketHint();
        } else {
            $message .= ' <em>The downloaded file was not a valid archive. This is usually a transient upstream issue (rate limit, network, or provider outage) — try again. If it persists, check the log under WP Pusher → Log.</em>';
        }

        $this->logError('incompatible_archive', $message);

        return new WP_Error('incompatible_archive', $message);
    }

    private function renderErrorData($data)
    {
        if (empty($data)) {
            return '';
        }
        if (is_scalar($data)) {
            return ' <code>' . esc_html((string) $data) . '</code>';
        }
        if (is_array($data) || is_object($data)) {
            $encoded = wp_json_encode($data);
            if (is_string($encoded) && $encoded !== '') {
                if (strlen($encoded) > 300) {
                    $encoded = substr($encoded, 0, 300) . '…';
                }
                return ' <code>' . esc_html($encoded) . '</code>';
            }
        }
        return '';
    }

    private function renderBitbucketHint()
    {
        return ' If you are using Bitbucket, maybe your token has been invalidated. Try obtaining <a href="admin.php?page=wppusher&tab=bitbucket">a new one</a>.';
    }

    private function renderBitbucketAuthDetail()
    {
        $detail = $this->getBitbucketAuthError();
        if ( ! $detail) {
            return '';
        }
        return ' <strong>Bitbucket token exchange failed:</strong> ' . esc_html($detail) . '. This is usually transient — retry; if it persists, re-issue the token at <a href="admin.php?page=wppusher&tab=bitbucket">WP Pusher → Bitbucket</a>.';
    }

    private function getBitbucketAuthError()
    {
        if ( ! isset($this->upgrader) || ! isset($this->upgrader->theme)) {
            return null;
        }
        $theme = $this->upgrader->theme;
        if ( ! isset($theme->repository) || ! isset($theme->repository->lastAuthError)) {
            return null;
        }
        return $theme->repository->lastAuthError ?: null;
    }

    private function getRepositoryCode()
    {
        if (isset($this->upgrader, $this->upgrader->theme, $this->upgrader->theme->repository->code)) {
            return $this->upgrader->theme->repository->code;
        }
        if (isset($_POST['wppusher']['type']) && is_string($_POST['wppusher']['type'])) {
            return $_POST['wppusher']['type'];
        }
        return null;
    }

    private function logError($code, $message)
    {
        $pusher = Pusher::getInstance();
        if ( ! $pusher) {
            return;
        }
        try {
            $logger = $pusher->make('Pusher\Log\Logger');
        } catch (Exception $e) {
            return;
        }
        $plain = trim(wp_strip_all_tags($message));
        $logger->error("Theme install/update failed ({$code}): {$plain}");
    }

    public function before()
    {
        // ...
    }

    public function error($error)
    {
        $this->error = $error;
    }

    public function header()
    {
        // ...
    }

    public function feedback($string, ...$args)
    {
        $this->feedback[$string] = true;
    }

    public function footer()
    {
        // ...
    }
}
