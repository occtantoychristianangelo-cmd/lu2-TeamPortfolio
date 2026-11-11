<?php

namespace Pusher\Storage;

/**
 * The last deploy WP Pusher made of each package: which commit, and when.
 *
 * This lives in an option rather than in a column on the packages table because that
 * table is only ever created by the activation hook, and WordPress does not run the
 * activation hook when a plugin is updated in place. A new column would exist on fresh
 * installs and be missing on every site that upgraded into it.
 */
class DeployRecords
{
    const OPTION = 'wppusher_deploys';

    /**
     * @param string $type    'plugin' or 'theme'
     * @param string $package the package identifier (plugin file / stylesheet)
     * @param string|null $commit
     * @param string $deployedAt
     */
    public function record($type, $package, $commit, $deployedAt)
    {
        $records = $this->all();

        $records[$this->key($type, $package)] = array(
            'commit' => $commit,
            'deployed_at' => $deployedAt,
        );

        // Not autoloaded: this is only read on the twice-daily heartbeat, never on a
        // front end request.
        update_option(self::OPTION, $records, false);
    }

    /**
     * @param string $type
     * @param string $package
     * @return array with 'commit' and 'deployed_at', both null when nothing is recorded
     */
    public function get($type, $package)
    {
        $records = $this->all();
        $key = $this->key($type, $package);

        if ( ! isset($records[$key]) or ! is_array($records[$key])) {
            return array('commit' => null, 'deployed_at' => null);
        }

        return array_merge(array('commit' => null, 'deployed_at' => null), $records[$key]);
    }

    /**
     * @return array
     */
    public function all()
    {
        $records = get_option(self::OPTION, array());

        return is_array($records) ? $records : array();
    }

    private function key($type, $package)
    {
        return $type . ':' . $package;
    }
}
