<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Util\Filesystem;

use Kompakt\Mediameister\Util\Filesystem\Exception\InvalidArgumentException;

class Directory
{
    protected $dir = null;

    public function __construct($dir)
    {
        $info = new \SplFileInfo($dir);

        if (!$info->isDir())
        {
            throw new InvalidArgumentException(sprintf('Dir not found'));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('Dir not readable'));
        }

        $this->dir = $dir;
    }

    /*
     * Copy the children of this directory into targetDir
     *
     * @param string $targetDir Target directory pathname
     *
     * @return void
     */
    public function copyChildren($targetDir)
    {
        $info = new \SplFileInfo($targetDir);

        if (!$info->isDir())
        {
            throw new InvalidArgumentException(sprintf('Target dir not found'));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('Target dir not readable'));
        }

        if (!$info->isWritable())
        {
            throw new InvalidArgumentException(sprintf('Target dir not writable'));
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach($files as $info)
        {
            $sourcePathname = $info->getPathname();
            $subdirPathname = $this->subtractBasedir($sourcePathname, $this->dir);
            $targetPathname = sprintf('%s/%s', $targetDir, $subdirPathname);

            if ($info->isDir())
            {
                mkdir($targetPathname);
            }
            else {
                copy($sourcePathname, $targetPathname);
            }
        }
    }

    /*
     * Move the children of this directory into targetDir
     *
     * @param string $targetDir Target directory pathname
     *
     * @return void
     */
    public function moveChildren($targetDir)
    {
        $info = new \SplFileInfo($targetDir);

        if (!$info->isDir())
        {
            throw new InvalidArgumentException(sprintf('Target dir not found'));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('Target dir not readable'));
        }

        if (!$info->isWritable())
        {
            throw new InvalidArgumentException(sprintf('Target dir not writable'));
        }

        foreach (new \DirectoryIterator($this->dir) as $info)
        {
            if ($info->isDot())
            {
                continue;
            }

            $sourcePathname = $info->getPathname();
            $subdirPathname = $this->subtractBasedir($sourcePathname, $this->dir);
            $targetPathname = sprintf('%s/%s', $targetDir, $subdirPathname);
            rename($sourcePathname, $targetPathname);
        }
    }

    public function delete()
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach($files as $info)
        {
            if ($info->isDir())
            {
                rmdir($info->getPathname());
            }
            else {
                unlink($info->getPathname());
            }
        }

        rmdir($this->dir);
    }

    /*
     * Subtract baseDir from pathname
     *
     * @param string $pathname The full pathname
     * @param string $baseDir The base pathname within pathname
     *
     * @return string Subdir portion, slashes cut off on both sides
     */
    protected function subtractBasedir($pathname, $baseDir)
    {
        $baseDir = str_replace('/', '\/', trim($baseDir, '/'));
        return trim(preg_replace(sprintf('/%s/', $baseDir), '', $pathname), '/');
    }
}