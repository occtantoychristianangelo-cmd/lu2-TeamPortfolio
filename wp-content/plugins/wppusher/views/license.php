<?php

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

?>

<br>

<?php settings_errors(); ?>

<form method="post" action="<?php echo admin_url(); ?>options.php">
    <?php settings_fields('pusher-license-settings'); ?>
    <?php do_settings_sections('pusher-license-settings'); ?>
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label>License</label>
            </th>
            <td>
            <?php if ($license_key) { ?>
                <?php if ($license_key->hasExpired()) { echo "<p style=\"color: #a00;\">Your license key has expired.</p>"; } ?>
                <p>Your license has <strong><?php echo ($license_key->licenses() > 0) ? $license_key->licenses() : 'unlimited'; ?></strong> site installs. <strong><?php echo $license_key->usedLicenses(); ?></strong> of them are in use.</p>
                <p>Licenses are <i><a href="https://wppusher.com/faq#renewals">automatically being renewed</a></i>.</p>
            <?php } else { ?>
                <p><i>You haven't registered any license key for this installation. <strong><a href="https://wppusher.com/?utm_source=plugin&utm_medium=license_tab#pricing">Buy one here</a>.</i></strong></p>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label>License key</label>
            </th>
            <td>
                <input name="wppusher_license_key" type="text" id="wppusher_license_key" placeholder="<?php echo (get_option('wppusher_license_key')) ? '********' : null; ?>" class="regular-text" <?php echo (get_option('wppusher_license_key')) ? 'disabled' : null; ?>>
                &nbsp; <input type="submit" name="submit" id="submit" class="button" value="<?php echo (get_option('wppusher_license_key')) ? 'Revoke license from site' : 'Activate site license'; ?>">
            </td>
        </tr>
        </tbody>
    </table>
</form>

<?php if (get_option('wppusher_license_key')) { ?>
<form method="post" action="<?php echo esc_url(admin_url('options.php')); ?>">
    <?php settings_fields('pusher-deploy-reports-settings'); ?>
    <?php do_settings_sections('pusher-deploy-reports-settings'); ?>
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <label>Deploy reports</label>
            </th>
            <td>
                <?php // The hidden field is what an unticked checkbox posts - a browser sends nothing for it. ?>
                <input type="hidden" name="<?php echo esc_attr(Pusher\Services\DeployReporter::REPORTING_OPTION); ?>" value="0">
                <?php // Ticked reflects the per-site override, not the effective state - the paragraph below says whether anything is actually being sent. ?>
                <label>
                    <input type="checkbox" name="<?php echo esc_attr(Pusher\Services\DeployReporter::REPORTING_OPTION); ?>" value="1" <?php echo (Pusher\Services\DeployReporter::siteAllowsReporting()) ? 'checked' : null; ?>>
                    Send deploy reports and the package list to the WP Pusher dashboard
                </label>
                <p class="description">
                    <?php if (Pusher\Services\DeployReporter::serverEnablesReporting()) { ?>
                        Deploy reports are on for your WP Pusher account, because the account has an Agent API key. Untick the box to stop this site sending them; the rest of your sites are not affected.
                    <?php } else { ?>
                        Deploy reports are off. They stay off until you create an Agent API key on your <a href="https://dashboard.wppusher.com/">WP Pusher dashboard</a>, which turns them on for every site on your license - each site picks that up the next time it checks your license, within a day. Unticking the box here keeps this one site off even then.
                    <?php } ?>
                </p>
                <p class="description">
                    While they are on: when a plugin or theme is deployed, WP Pusher sends the package name, the repository and branch it came from, the commit hash, your site URL and your license key to wppusher.com, and sends the same list of your WP Pusher packages once every twelve hours. Never your file contents, and never your GitHub, Bitbucket or GitLab credentials. It is what makes deploy status visible in your WP Pusher dashboard and readable through the Agent API. Your deploys are recorded on this site either way, so switching reporting on brings the dashboard up to date without waiting for a new deploy.
                </p>
                <p class="description">
                    Your license is not affected by this setting. WP Pusher always sends your license key and site URL when it verifies the license and when it checks for plugin updates - that is the license itself. A site with no license key configured sends nothing at all.
                </p>
            </td>
        </tr>
        </tbody>
    </table>
    <?php submit_button('Save'); ?>
</form>
<?php } ?>
<br>
