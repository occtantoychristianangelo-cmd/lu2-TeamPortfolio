=== WP Pusher ===
Tags: git, deploy, deployment, github, workflow
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.2
Stable tag: 3.0.20
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Deploy directly from GitHub and never again copy files over FTP. It works everywhere - even on cheap shared hosting!

== Description ==

= Features =

* Install and update your WordPress themes and plugins directly from GitHub
* BitBucket and GitLab support
* Easy version control of your clients code
* Works everywhere because it hooks in to the WordPress core auto updater
* No Git or SSH needed on the server
* **Push-to-deploy** can automatically trigger updates when whenever you push to GitHub
* Support for branches

[Learn more about pricing](http://wppusher.com/#licenses)

= Get started =

If you already use Git for your projects and your themes and plugins are in their own repositories on GitHub, getting started with WP Pusher is simple and easy. Just go to "New plugin" or "New theme" in the WP Pusher menu and type in the repository for the package: github-username/repository-name

If any of your plugins or themes are in private repositories on GitHub, WP Pusher will need a token to access them. You can read GitHub's guide to application tokens [here](https://help.github.com/articles/creating-an-access-token-for-command-line-use/). Paste in the token at WP Pusher settings page.

= Conventions =

* Theme stylesheets _must_ be named the same as the repository
* Plugin directories _must_ be named the same as the repository
* GitHub version tags _must_ be numeric, such as '1.0' or '1.0.1', with an optional preceding 'v', such as 'v1.0.1'
* WordPress version tags _must_ be numeric, such as '1.0' or '1.0.1'

= Git workflow =

The way WP Pusher works, packages (themes and plugins) need to be in their own repositories. If your packages are in their own repositories already, you can safely skip this section. Some developers prefer having their whole WordPress installation under Git, which potentially makes things a bit more complicated. By having all packages in their own repositories, you can easily share code across clients / projects. Since you shouldn’t be editing the core WordPress code, in most cases having the whole project under Git shouldn’t be necessary. However, if for some reason your project require that you have one Git repository for the whole project, you will have to use Git submodules, so that you can still have every package in its own (sub) repository.

== What WP Pusher sends to wppusher.com ==

WP Pusher talks to two of our servers: wppusher.com, which issues and verifies license keys and serves plugin updates, and dashboard.wppusher.com, which shows what your sites have deployed. A site with no license key configured sends nothing to either of them, in any of the categories below. Your code never leaves your site, and your GitHub, Bitbucket and GitLab credentials are never sent anywhere except to GitHub, Bitbucket and GitLab.

There are three categories.

1. License verification - always, on licensed sites. Your license key and your site URL are sent when you activate or revoke a license on a site, and once a day to check the license is still active. This is the license itself: what you are allowed to deploy depends on the answer, so it cannot be switched off.

2. Update check identification - always, on licensed sites. WordPress asks our update server twice a day whether a newer WP Pusher is available. Since 3.0.16 that request carries your license key and site URL, so we can see the license is installed on a live site - for example, to spot a subscription still billing for a site that no longer exists. Part of the license too, so it cannot be switched off either.

3. Deploy reports and your package list - off unless you turn them on. Creating an Agent API key on your WP Pusher dashboard switches them on for every site on your license; each site picks that up the next time it checks your license, within a day. The "Send deploy reports and the package list to the WP Pusher dashboard" checkbox on the WP Pusher license tab is a per-site override that switches them back off for that one site. While they are on, WP Pusher sends the package name, the repository and branch it came from, the commit hash, your site URL and your license key when a plugin or theme is deployed, and sends the same list of your WP Pusher packages once every twelve hours. That is what makes deploy status visible in your dashboard and readable through the WP Pusher Agent API. Deploys are recorded on your own site either way, so switching reporting on brings the dashboard up to date without waiting for a new deploy.

Our privacy policy is at [https://wppusher.com/privacy/](https://wppusher.com/privacy/).

== Installation ==

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `wp-pusher.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `wp-pusher.zip`
2. Extract the `wppusher` directory to your computer
3. Upload the `wppusher` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Screenshots ==

1. Plugins installed and managed with WP Pusher
2. The WP Pusher dashboard
3. Manage themes and plugins from the dashboard

== Changelog ==

= 3.0.20 =

* An update that fails part way no longer leaves your plugin or theme deleted or empty. WordPress replaces a package by deleting the old files and then copying the new ones in, so a copy that broke half way (a full disk, a timeout, a file the server couldn't write) left the site with nothing there. For the active theme that meant a broken site. WP Pusher now prepares the new version next to the live one, checks that it arrived complete, and only then swaps it into place. If anything goes wrong before the swap, the site keeps running the version it had.
* Removes the Branch CI/CD tab from the WP Pusher screens. Its links pointed to branchci.com, a domain we no longer control, which now leads to an unrelated gambling site. Nothing else about WP Pusher depended on that tab.
* WP Pusher runs on PHP 7.2 and newer again. 3.0.19 listed PHP 7.4 as the minimum; if your host is still on PHP 7.2 or 7.3, you can install and update WP Pusher there, and every release is now tested on those versions before it ships.
* A deploy that fails no longer leaves the plugin switched off. WordPress turns a plugin off while it updates it and only turns it back on when the update succeeds, so a failed deploy (a download error, a full disk, a permissions problem) left the plugin deactivated even though its files were untouched. WP Pusher now switches the plugin back on after a failed deploy as well, so the site keeps running the version it had.

= 3.0.19 =

* Fixes a plugin or theme being left switched off, or deleted from the site altogether, when the same package was deployed twice at the same moment. If two Push-to-Deploy deliveries for one package arrived in the same second - a repository wired up to more than one webhook, a single push fanning out to several deploys, or an impatient second click of the Update button - both deploys ran at once, and each replaced the package's directory while the other was still writing into it. What you saw was "Filesystem error" in the log and a plugin that had vanished or quietly deactivated itself. WP Pusher now deploys one version of a package at a time: while a deploy is running, a second deploy of that same package is skipped and noted in the log rather than run alongside it. Deploys of different packages still happen side by side, exactly as before.
* WP Pusher now requires WordPress 6.0 or newer and PHP 7.4 or newer.
* Updates/clean up to the license checking logic
* WP Pusher can now tell your WP Pusher dashboard which commit each site has deployed, and when. That is what lets you - or a coding agent working on your behalf - check whether a push actually reached a site without logging into wp-admin. This is off unless you turn it on: create an Agent API key on your WP Pusher dashboard and every site on your license starts reporting within a day, with no setting to find on each site. A report is then sent when a plugin or theme is installed or updated, and the full list of your deployed packages once every twelve hours alongside the update check that already runs. Nothing is sent from a site with no license key configured, and nothing about your code goes with it: only the package name, the repository and branch it came from, and the commit that landed. No file contents, and never your GitHub, Bitbucket or GitLab credentials. The WP Pusher license tab has a new checkbox that switches reporting off again for a single site, and because deploys are recorded on your own site either way, switching reporting on brings the dashboard up to date without waiting for a new deploy. The readme's new "What WP Pusher sends to wppusher.com" section lists everything the plugin sends and why.

= 3.0.18 =

* Security fix (cross-site scripting). The Troubleshooting tab printed the raw replies from the WP Pusher, GitHub, Bitbucket and GitLab servers straight onto the page whenever a connection test failed. Whatever a reply contained was treated as part of the admin page, so a hostile or hijacked server at the other end — including a self-hosted GitLab address entered in your own settings — could run scripts in a logged-in administrator's browser. The diagnostic output is now shown as plain text.
* Dismissing the WP Pusher welcome panel now requires being logged in as an administrator. The "Dismiss" link's address previously worked for anyone who visited it, logged in or not, so a link elsewhere on the web could hide the panel on your site. Nothing else about the panel changed.
* Fixes a failed theme or plugin update leaving the entire site stuck on the "Briefly unavailable for scheduled maintenance" page. When WP Pusher updated your active theme — or any package on a multisite network — and the update failed, WordPress switched maintenance mode on but never switched it off again. The admin saw an error message and assumed the update had simply failed, while every visitor got the maintenance page until someone deleted the `.maintenance` file by hand over FTP. Maintenance mode is now always switched off when an update finishes, whether it succeeded or failed.

= 3.0.17 =

* Security fix (SQL injection). Values taken straight from the web request - the package and repository parameters used by WP Pusher's admin screens and by the Push-to-Deploy webhook - were pasted directly into database queries. The only cleaning applied did not escape quote characters, so a crafted request could alter what those queries did to your WordPress database. Every affected query now uses a prepared statement. All versions up to and including 3.0.16 are affected, so please update.
* Security fix (cross-site scripting). On the Install Plugin and Install Theme screens, the Repository, Branch and Subdirectory fields were echoed back into the form without being escaped, and the form's security-token check was skipped whenever the submitted action was not one WP Pusher recognises. Together that meant a specially crafted link or form could run scripts in a logged-in administrator's browser. All three fields are now escaped. All versions up to and including 3.0.16 are affected, so please update.
* Prevents a fatal error (white screen) when another active plugin defines a PHP class with the same name as WP Pusher's — most commonly BuddyBoss, which bundles the Pusher library. Instead of the site crashing, WP Pusher now stops itself and shows an explanatory notice in the admin telling you which plugin conflicts.
* Further hardens the twice-daily update-check filter (the one behind the 3.0.16 PHP 8 fix). It runs on every update check and could still throw a fatal `TypeError` if another plugin sent an update-check request in an unexpected format; it now checks the request shape before touching it, and keeps the active-plugins list correctly formatted when a WP Pusher package is removed from it.

= 3.0.16 =

* Fixes a fatal `TypeError` on PHP 8 (`array_search(): Argument #2 must be of type array, null given`) at wppusher.php line 82. WP Pusher's filter that hides its own packages from WordPress.org update checks assumed the update payload always contained an `active` key; when it was missing/null (e.g. alongside some other plugins), the plugins screen and WP-CLI would crash. The `active` list is now guarded before use.
* Fixes PHP 8.2 "Creation of dynamic property is deprecated" notices by declaring the previously-dynamic properties `Pusher\Log\Logger::$file`, `Pusher\Dashboard::$pusher`, and `Pusher\Theme::$repository`.
* Fixes misleading error messages when an install or update fails while the downloaded files are being moved into place. Every one of these failures used to report "WP Pusher couldn't find subdirectory in repository", which sent people looking in the wrong place. The message now states the real cause: a missing subdirectory is named along with what the repository root actually contains, an empty checkout is reported as an empty checkout, and a permissions or filesystem failure says so and names the filesystem method in use. Applies to both plugin and theme installs and updates.
* The twice-daily plugin update check now identifies your site URL and license key to the WP Pusher update server, so we can see that your license is still actively installed on a live site. Update checks were previously anonymous. This lets us support you proactively — for example, spotting subscriptions that are still billing for sites that no longer exist. No other data is collected, and nothing is sent if no license key is configured.

= 3.0.15 =

* Fixes Push-to-Deploy webhooks failing on Bitbucket because the webhook URL was not URL-encoded. The base64-encoded package path could end in a `=` character, which Bitbucket rejected as a malformed URL (delivery failed with HTTP status -2 / no response). The package parameter is now URL-encoded.
* Bitbucket webhook creation now sends the access token in the `Authorization: Bearer` header instead of a deprecated query parameter, and reports authentication failures clearly instead of failing silently during install.

= 3.0.14 =

* Fixes Bitbucket installs and updates failing with `PCLZIP_ERR_BAD_FORMAT` after Bitbucket deprecated query-parameter OAuth (CHANGE-3052). The plugin now sends the access token in the `Authorization: Bearer` header.

= 3.0.13 =

* Fixes an issue where the WordPress 5.9 welcome panel styles were bleeding over into WP Pusher's welcome panel
* Adds cURL stats to the troubleshooting tab

= 3.0.12 =

* Adds the "Troubleshooting" tab to help you debug your installation if something's not working properly.

= 3.0.11 =

* Version bump for deployment

= 3.0.10 =

* Version bump for deployment

= 3.0.9 =

* Additional logging to assist with remote debugging, specifically around connecting to the license server

= 3.0.8 =

* Continued work on fix for WP 5.6 issue with empty transients (failing theme updates)

= 3.0.7 =

* Fix deprecation warnings related the PHP reflection API in PHP 8
* Improve error messages for GitHub
* Add error message for subdirectories that doesn't exist

= 3.0.6 =

* Fix WP 5.6 issue with empty transients (failing plugin updates)

= 3.0.5 =

* Roll back to old plugins/themes views. We're so sorry about this! We thought we could make a few incremental improvements to the user experience, but ultimately ended up breaking critical features for folks. Not our typical style, which is why we're now rolling back to the old plugins/themes list instead of plugging holes. We promise to give this some love an attention soon - doing our best not to break anything! Again, sorry about this!

= 3.0.4 =

* Fix PHP warning introduced in 3.0.3. Sorry about that one!

= 3.0.3 =

* Consolidates the plugins and themes overview into one repositories screen.

= 3.0.2 =

* GitHub is deprecating URL based token auth. Please update to this version of WP Pusher before May 2020, to keep using GitHub.

= 3.0.1 =

* [Bugfix] Get rid of notices in Plugin.php and Theme.php

= 3.0.0 =

NB: If you are on an older version of WordPress, this version of WP Pusher can result in PHP warnings.

* [Bugfix] Make theme and plugin upgrader skins compatible with WP 5.3. This is due to a breaking change in WP core. If you have questions, feel free to contact support.

= 2.4.12 =

* [Bugfix] Make sure WP Pusher only shows up in the menu for admins

= 2.4.11 =

* [Bugfix] Support special characters in GitHub branch names

= 2.4.10 =

* Make sure everything is casted to a string before it's handed off to the DB layer (fixes WP 5.1 DB issues)

= 2.4.9 =

* Addition to previous fix, where repository handle is empty in DB

= 2.4.8 =

* Fix bug where repository handle is empty in DB

= 2.4.7 =

* Use GitLab API v4

= 2.4.6 =

* Fix "PHP Notice: Undefined index" when looking for updates

= 2.4.5 =

* New plugin and themes overview in WP Pusher - uses tables instead of the squares

= 2.4.4 =

* Add links to help center
* Fix typo in menu
* Fix WP Pusher icon styling in WordPress 4.9.1
* Fix broken links to WP Pusher website

= 2.4.3 =

* Always add trailing slashes to Push-to-Deploy URLs, to prevent redirects (that GitHub and Bitbucket won't follow). This should not be a breaking change, since 1. root level URLs (wppusher.com) are the same with or without trailing slashes (.com vs .com/) and 2. WordPress always add a trailing slash to a site in a subdirectory (wppusher.com/blog/).

= 2.4.2 =

* Feature: Select themes directly from GitHub
* Better onboarding flow with links to new documentation

= 2.4.1 =

* Fix bug where default GitLab branch is installed even if another branch is specified in WP Pusher

= 2.4.0 =

* Improved navigation
* Connected WP Pusher to new plugin update system to provide more stable releases

= 2.3.1 =

* Small fixes to links in plugin
* Fix bug: Can't select Push-to-Deploy URL

= 2.3.0 =

* Connect WP Pusher to the new WP Pusher Dashboard API (to be announced soon)

= 2.2.0 =

New features:

* Add hook to modify plugin zipball url, so plugins can basically be installed from everywhere
* `wppusher_register_dependency` action to inject dependencies into the WP Pusher container
* Better installation screens
* Pick repository directly from GitHub feature

Bugfixes:

* New webhooks fixes subdirectory issues

= 2.2.1 =

New features:

* Don't show WP Pusher license key in the dashboard

= 2.1.1 =

Bugfixes:

* Bitbucket tokens were expiring and as a fix, tokens are now being refreshed through our OAuth service on every request to GitHub. Sorry for the troubles!

= 2.1.0 =

New features:

* 1-click authentication with GitHub and Bitbucket
* Automatic set up of Push-to-Deploy on GitHub and Bitbucket - just tick the box
* Use Bitbucket OAuth token instead of username/password - much more safe and easy
* Do action for failed updates - useful for notifications
* Link to new license manager dashboard

Bug fixes:

* Fix broken links to new landing page
* Show error when license has reached its activation limit
* Notify user when license has expired

= 2.0.4 =

Bugfixes:

* Fix GitHub API zipball path for private repositories

= 2.0.3 =

* License install count not shown correct

= 2.0.2 =

Breaking changes:

* New update mechanism, since wp-updates.com has abandoned ship without notice! :sad_panda:

= 2.0.1 =

Bugfixes:

* Active installs for licenses was being displayed incorrect under some circumstances

= 2.0.0 =

Breaking changes:

* Push-to-Deploy: The webhook url now works on a plugin/theme basis, meaning that each plugin and theme has its own unique URL. Please update your webhooks on GitHub and Bitbucket.
* The Pusherfile has been removed from WP Pusher. It's main purpose was to support Composer, and I'm working on an extension instead to provide this functionality.

Bugfixes:

* Licenses are revoked on uninstall
* Error messages have been improved

New Features:

* The UI has been improved
* Behind the scene, most code have been refactored to show better error messages etc.

New extensions:

* WP Pusher Slack Notifications: https://github.com/wppusher/wppusher-slack

= 1.1.8 =

Bugfixes:

* Update plugin to handle changes in Bitbucket webhooks

= 1.1.7 =

* Issues with database table prefixes in network installations

= 1.1.6 =

Bugfixes:

* Exclude WP Pusher plugins and themes from w.org update checks

New stuff:

* Install plugins and themes from subdirectories (like wp-content/themes/Awesome-Theme)
* Friendly welcome hero unit after install

= 1.1.5 =

Bugfixes:

* 2 options not being deleted on uninstall
* Bug using multiple networks plugin
* Small fix to licenses

= 1.1.4 =

Bugfixes:

* Failing SQL query on Multisite installations in plugin overview
* Add index.php files to all directories and make sure no template files are directly accessible

New stuff:

* Add link to documentation in footer (documentation updates coming soon)

= 1.1.3 =

Bugfixes:

* Make sure we don't get stuck in maintenance mode if installation fails
* Plugins were accidentally reactivated for the network, even if they were only activated for one site

= 1.1.2 =

Bugfixes:

* Push-to-Deploy not showing on edit package pages

= 1.1.1 =

Bugfixes:

* Settings API bug: Updating license key could result in reset Push-to-Deploy token (if you experience this, you need to copy the new web hook URL from the dashboard to GitHub / Bitbucket / GitLab. Sorry!!)

New stuff:

* New UI on plugins and themes overview
* Unlink packages from WP Pusher (connect them again with "dry run")
* WP 4.2 style spinning wheels on update buttons
* Dedicated pages to edit packages

= 1.1.0 =

* New licensing model
* Free version now supports Push-to-Deploy and branches
* Private repositories will from now on require a license

= 1.0.9 =

* Logger: Enable / disable logging for debug purposes
* Use HTTPS for WP Pusher logo

= 1.0.8 =

* Push-to-Deploy for GitLab repositories
* Remove 'manage' links on multisite
* DB cleanup of delete plugins

= 1.0.7 =

* Bug when installing and updating themes

= 1.0.6 =

* Support for including a wppusher.php file to run commands on installation and updating: https://gist.github.com/petersuhm/9b7f4e4886519fc3a8a8
* Actions after packages are installed or updated
* Support for GitLab

= 1.0.5 =

* Add dry run feature in order to set up already installed plugins

= 1.0.4 =

* Auto updates

= 1.0.3 =

* Bugfix: Make sure plugin is reactivated after update
* Activation links on multisite
* Support for dots in repository names

= 1.0.2 =

* Added support for multisite setups

= 1.0.1 =
* Add support for branches in Pro version

= 1.0.0 =
* No more beta
* Release of WP Pusher Pro

= 0.1.2 =
* Minor bugfixes

= 0.1.1 =
* Bitbucket support for public and private repositories
* Activate repositories directly after installation
* Better house keeping after plugin deletion

= 0.1.0 =
* Public BETA release
