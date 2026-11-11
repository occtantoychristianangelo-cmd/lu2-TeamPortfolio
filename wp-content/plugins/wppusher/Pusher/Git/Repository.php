<?php

namespace Pusher\Git;

use Exception;

class Repository
{
    protected $handle;
    protected $branch;
    protected $private = 0;

    public function __construct($handle)
    {
        if ( ! $this->validate($handle))
            throw new Exception("Repository is not valid.");
            
        $this->handle = $handle;
    }

    public function validate($repo)
    {
        // For now, don't validate repositories
        // preg_match('/^[a-zA-Z0-9_-\d\.]+[\/]+[a-zA-Z0-9_-\d\.]*+$/', $repo, $match);

        // if (count($match) === 0) return false;

        return true;
    }

    public function getBranch()
    {
        if ( ! $this->branch || $this->branch === '') return 'master';

        return $this->branch;
    }

    public function setBranch($branch)
    {
        $this->branch = $branch;
    }

    public function getSlug()
    {
        $elements = preg_split('/\//', $this->handle);

        if ( ! isset($elements[1]))
            throw new Exception('Repository could not be parsed.');

        return $elements[1];
    }

    public function makePrivate()
    {
        $this->private = 1;
    }

    public function isPrivate()
    {
        return $this->private;
    }

    public function __toString()
    {
        return $this->handle;
    }

    /**
     * The commit a downloaded branch archive was built from.
     *
     * WP Pusher downloads a ZIP rather than cloning, so there is no .git on disk to
     * ask. All three hosts name the single top level directory inside a branch archive
     * after the commit: `owner-repo-<sha>` on GitHub and Bitbucket, `repo-branch-<sha>`
     * on GitLab. That directory name is the only place the commit ever appears, and it
     * is gone once the files are moved into place.
     *
     * Returns null when the trailing segment is not a hash - a host that changes its
     * naming, or a hand built ZIP - so a deploy report carries no commit rather than a
     * wrong one.
     *
     * @param string $path path to the unpacked archive root
     * @return string|null
     */
    public static function commitFromArchivePath($path)
    {
        $parts = explode('-', basename(untrailingslashit($path)));

        if (count($parts) < 2) {
            return null;
        }

        $last = end($parts);

        if ( ! preg_match('/^[0-9a-f]{7,40}$/', $last)) {
            return null;
        }

        return $last;
    }
}
