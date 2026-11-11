<?php

namespace Pusher\WordPress;

include_once(ABSPATH . 'wp-admin/includes/theme.php');
include_once(ABSPATH . 'wp-admin/includes/file.php');
include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
include_once(ABSPATH . 'wp-admin/includes/misc.php');

use Pusher\Dashboard;
use Pusher\Git\Repository;
use Pusher\Log\Logger;
use Theme_Upgrader;
use Pusher\Theme;
use stdClass;

class ThemeUpgrader extends Theme_Upgrader
{
    public $theme;

    /**
     * The commit the archive we just unpacked was built from, or null when it could
     * not be read. Set by upgraderSourceSelectionFilter(), which is the only point in
     * an install or update where the archive's own directory name still exists.
     */
    public $deployedCommit;

    /**
     * Where upgrader_source_selection left the unpacked package. clear_destination()
     * stages it next to the live directory and swaps it in (#197).
     */
    public $stagedSource;

    /**
     * True once clear_destination() has dealt with the live directory, so core's own
     * delete_old_theme() must not delete it afterwards.
     */
    protected $destinationHandled = false;

    public function __construct(ThemeUpgraderSkin $skin)
    {
        parent::__construct($skin);
    }

    public function installTheme(Theme $theme)
    {
        add_filter('upgrader_source_selection', array($this, 'upgraderSourceSelectionFilter'), 10, 3);

        $this->theme = $theme;

        parent::install($this->theme->repository->getZipUrl());

        // Make sure we get out of maintenance mode
        $this->maintenance_mode(false);
    }

    public function upgradeTheme(Theme $theme)
    {
        add_filter("pre_site_transient_update_themes", array($this, 'preSiteTransientUpdateThemesFilter'), 10, 3);
        add_filter('upgrader_source_selection', array($this, 'upgraderSourceSelectionFilter'), 10, 3);

        $this->theme = $theme;

        try {
            parent::upgrade($this->theme->stylesheet);
        } finally {
            // Make sure we get out of maintenance mode, also when the update failed.
            // The skin throws out of parent::upgrade(), so without the finally neither
            // this nor WordPress' own call runs and the site stays in maintenance mode
            // until someone deletes .maintenance by hand.
            $this->maintenance_mode(false);
        }
    }

    /**
     * Since WordPress 6.3 an update moves the live directory into upgrade-temp-backup
     * before clear_destination() runs, and only moves it back on shutdown. That leaves
     * nothing to swap and an empty directory if the copy fails, so our deploys leave it
     * out: clear_destination() never touches the live directory until the new version
     * is staged.
     */
    public function run($options)
    {
        unset($options['hook_extra']['temp_backup']);

        $this->stagedSource = null;
        $this->destinationHandled = false;

        return parent::run($options);
    }

    /**
     * Core deletes the live directory here and copies the new version in afterwards.
     * We stage the new version next to it and rename it into place instead, so a failed
     * copy leaves the live theme untouched (#197, #164).
     */
    public function clear_destination($remote_destination)
    {
        global $wp_filesystem;

        if ( ! $this->stagedSource or ! is_object($wp_filesystem)) {
            return parent::clear_destination($remote_destination);
        }

        $result = (new AtomicSwap($wp_filesystem))->swap($this->stagedSource, $remote_destination);

        if ( ! is_wp_error($result)) {
            $this->destinationHandled = true;
        }

        return $result;
    }

    /**
     * Hooked by core to upgrader_clear_destination. After a swap the directory it would
     * delete is the new version; after the in-place fallback it is the only copy.
     */
    public function delete_old_theme($removed, $local_destination, $remote_destination, $theme)
    {
        if ($this->destinationHandled) {
            return $removed;
        }

        return parent::delete_old_theme($removed, $local_destination, $remote_destination, $theme);
    }

    public function getDeployedCommit()
    {
        return $this->deployedCommit;
    }

    public function upgraderSourceSelectionFilter($source, $remote_source, $upgrader)
    {
        $repositoryRoot = $source;

        $this->deployedCommit = Repository::commitFromArchivePath($repositoryRoot);

        if ($upgrader->theme->hasSubdirectory()) {
            $source = trailingslashit($source) . trailingslashit($upgrader->theme->getSubdirectory());
        }

        $newSource = trailingslashit($remote_source) . trailingslashit($upgrader->theme->getSlug());

        global $wp_filesystem;

        if ( ! is_object($wp_filesystem)) {
            return new \WP_Error('wppusher_no_filesystem', "WP Pusher could not access the WordPress filesystem. Check the <code>FS_METHOD</code> constant and the filesystem credentials for this site.");
        }

        if ( ! $wp_filesystem->is_dir($source)) {
            return $this->sourceNotFoundError($upgrader->theme, $source, $repositoryRoot);
        }

        if ( ! $wp_filesystem->move($source, $newSource, true)) {
            return $this->moveFailedError($source, $newSource);
        }

        $this->stagedSource = $newSource;

        return $newSource;
    }

    /**
     * The path we were about to move doesn't exist. With a subdirectory configured
     * that means the subdirectory isn't in the repository; without one it means the
     * checkout itself is empty.
     */
    protected function sourceNotFoundError(Theme $theme, $source, $repositoryRoot)
    {
        if ($theme->hasSubdirectory()) {
            return new \WP_Error('wppusher_subdirectory', sprintf(
                "WP Pusher couldn't find the subdirectory <code>%s</code> in the repository.%s",
                esc_html($theme->getSubdirectory()),
                $this->renderRepositoryListing($repositoryRoot)
            ));
        }

        return new \WP_Error('wppusher_source_not_found', sprintf(
            "WP Pusher couldn't find the downloaded files on disk (<code>%s</code>). The package was downloaded, but the unpacked checkout is empty or not where WordPress expected it.",
            esc_html($source)
        ));
    }

    /**
     * List the top level of the repository, so a mistyped subdirectory is visible
     * from the error message instead of requiring a manual checkout.
     */
    protected function renderRepositoryListing($repositoryRoot)
    {
        global $wp_filesystem;

        $list = $wp_filesystem->dirlist($repositoryRoot);

        if ( ! is_array($list) or empty($list)) {
            return '';
        }

        $names = array_slice(array_keys($list), 0, 20);

        return ' The repository root contains: <code>' . esc_html(implode(', ', $names)) . '</code>.';
    }

    /**
     * The source exists, so the repository layout is fine and the move itself failed -
     * usually permissions, ownership or a filesystem method that can't rename. This
     * used to be reported as a missing subdirectory, which sent people looking in the
     * wrong place.
     */
    protected function moveFailedError($source, $newSource)
    {
        global $wp_filesystem;

        $method = 'unknown';

        if (isset($wp_filesystem->method) and $wp_filesystem->method) {
            $method = $wp_filesystem->method;
        }

        $message = sprintf(
            "WP Pusher downloaded and unpacked the package, but could not move it into place. This is not a repository layout problem - the files are there. Tried to move <code>%s</code> to <code>%s</code> using the <code>%s</code> filesystem method. Check permissions and ownership on the WordPress uploads and themes directories.",
            esc_html($source),
            esc_html($newSource),
            esc_html($method)
        );

        if (isset($wp_filesystem->errors) and is_wp_error($wp_filesystem->errors) and $wp_filesystem->errors->get_error_code()) {
            $message .= ' Filesystem error: <code>' . esc_html($wp_filesystem->errors->get_error_message()) . '</code>';
        }

        return new \WP_Error('wppusher_move_failed', $message);
    }

    public function preSiteTransientUpdateThemesFilter($transient)
    {
        $options = array('package' => $this->theme->repository->getZipUrl());

        // If $transient doesn't exist - create it
        if (! $transient) {
            $transient = new stdClass;
        };

        $transient->response[$this->theme->stylesheet] = $options;

        return $transient;
    }
}
