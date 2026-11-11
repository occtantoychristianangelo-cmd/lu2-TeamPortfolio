<?php

namespace Pusher\WordPress;

use WP_Error;

/**
 * Puts a new version of a plugin or theme in place without ever deleting the live one
 * first (#197, and the "theme emptied after a failed update" failure in #164).
 *
 * WordPress core updates a package by deleting the live directory and then copying the
 * new files in. If the copy fails half way - disk quota, a timeout, a file the web server
 * can't write - the site is left with an empty or missing directory, and for the active
 * theme that is a broken site.
 *
 * Instead, the new files are copied into a staging directory next to the live one and
 * checked. Only then is the live directory renamed out of the way and the staging
 * directory renamed into its place. Every failure before that leaves the live directory
 * exactly as it was.
 *
 * Both side directories start with a dot, which WordPress skips when it scans for plugins
 * and themes, so they never show up as a package of their own.
 */
class AtomicSwap
{
    const STAGING_PREFIX = '.wppusher-staging-';
    const PREVIOUS_PREFIX = '.wppusher-previous-';

    /**
     * @var \WP_Filesystem_Base
     */
    private $filesystem;

    /**
     * True when the new version was renamed into place. False after an in-place
     * fallback, where core's own copy still has to put the files there.
     *
     * @var bool
     */
    public $swapped = false;

    /**
     * @param \WP_Filesystem_Base $filesystem
     */
    public function __construct($filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Stage $source next to $live and swap it in.
     *
     * Returns true when WordPress may carry on. That is either after a swap, or when the
     * swap is not possible on this host and core should overwrite the live directory in
     * place (without deleting it first). Returns a WP_Error when the update must stop -
     * in which case the live directory is untouched.
     *
     * @param string $source the unpacked package, as returned by upgrader_source_selection
     * @param string $live   the live plugin or theme directory
     *
     * @return true|WP_Error
     */
    public function swap($source, $live)
    {
        $source = trailingslashit($source);
        $live = untrailingslashit($live);

        $parent = trailingslashit(dirname($live));
        $staging = $parent . self::STAGING_PREFIX . basename($live);
        $previous = $parent . self::PREVIOUS_PREFIX . basename($live);

        $this->recoverInterruptedSwap($live, $previous);
        $this->remove($staging);

        // Nothing is live yet, so there is nothing to protect.
        if ( ! $this->filesystem->exists($live)) {
            return true;
        }

        $expected = $this->listing($source);

        if (empty($expected)) {
            return $this->stagingFailed($live, 'the downloaded package is empty');
        }

        if ( ! $this->filesystem->mkdir($staging, FS_CHMOD_DIR)) {
            return $this->stagingFailed($live, 'could not create ' . $staging);
        }

        $copied = $this->copy($source, $staging);

        if (is_wp_error($copied)) {
            $this->remove($staging);

            return $this->stagingFailed($live, $copied->get_error_message());
        }

        if ($this->listing($staging) !== $expected) {
            $this->remove($staging);

            return $this->stagingFailed($live, 'the staged copy does not match the downloaded package');
        }

        // A symlinked package directory (common on local setups) would be replaced by a
        // real one, and a host that can't rename directories can't swap at all. Fall
        // back to overwriting in place: the live directory is never emptied, but files
        // deleted from the repository stay behind until the next swap.
        if ($this->isSymlink($live) or ! $this->filesystem->move($live, $previous)) {
            $this->remove($staging);

            return true;
        }

        if ( ! $this->filesystem->move($staging, $live)) {
            $this->filesystem->move($previous, $live);
            $this->remove($staging);

            return new WP_Error('wppusher_swap_failed', sprintf(
                "WP Pusher staged the new version but could not move it into place, so <code>%s</code> was left on the previous version. Check permissions and ownership on its parent directory.",
                esc_html($live)
            ));
        }

        $this->remove($previous);

        // Core copies the source over the destination after clear_destination(). The
        // new files are already live, so leave it an empty directory to copy.
        $this->filesystem->delete($source, true);
        $this->filesystem->mkdir($source, FS_CHMOD_DIR);

        $this->swapped = true;

        return true;
    }

    /**
     * A deploy that died between the two renames (PHP timeout, killed request) leaves the
     * live directory missing and the previous version parked beside it. Put it back
     * before doing anything else.
     */
    protected function recoverInterruptedSwap($live, $previous)
    {
        if ( ! $this->filesystem->exists($previous)) {
            return;
        }

        if ( ! $this->filesystem->exists($live)) {
            $this->filesystem->move($previous, $live);

            return;
        }

        $this->remove($previous);
    }

    /**
     * @return true|WP_Error
     */
    protected function copy($from, $to)
    {
        return copy_dir($from, $to);
    }

    protected function isSymlink($path)
    {
        return isset($this->filesystem->method) and $this->filesystem->method === 'direct' and is_link($path);
    }

    /**
     * Top-level names in a directory, sorted, or an empty array if it can't be read.
     */
    protected function listing($path)
    {
        $list = $this->filesystem->dirlist($path);

        if ( ! is_array($list)) {
            return array();
        }

        $names = array_map('strval', array_keys($list));
        sort($names);

        return $names;
    }

    protected function remove($path)
    {
        if ($this->filesystem->exists($path)) {
            $this->filesystem->delete($path, true);
        }
    }

    protected function stagingFailed($live, $reason)
    {
        return new WP_Error('wppusher_staging_failed', sprintf(
            "WP Pusher could not prepare the new version (%s). Nothing was changed: <code>%s</code> is still the previous version.",
            esc_html($reason),
            esc_html($live)
        ));
    }
}
