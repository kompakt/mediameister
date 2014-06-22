<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Util\Archive;

use Kompakt\Mediameister\Util\Archive\Exception\InvalidArgumentException;

class FileAdder
{
    protected $zip = null;

    public function __construct(\ZipArchive $zip)
    {
        $this->zip = $zip;
    }

    /**
     * Recursively add children of directory to archive
     *
     * @example Pathname of '/share/lib' will add all children of '/share/lib', not including '/share/lib'
     *
     * @param string $dirPathname The full directory pathname
     */
    public function addChildren($dirPathname)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dirPathname, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach($files as $info)
        {
            $relativePathname = $this->subtractBasedir($info->getPathname(), $dirPathname);
            #echo sprintf("%s\n", $relativePathname);

            if ($info->isDir())
            {
                $this->zip->addEmptyDir($relativePathname);
            }
            else {
                $this->zip->addFile($info->getPathname(), $relativePathname);
            }
        }
    }

    /**
     * Calculate relative pathname within archive and add file
     *
     * @example Pathname of '/share/lib/readme.md' and basedir of '/share' will add 'lib/readme.md' to archive
     *
     * @param string $pathname The full pathname
     * @param string $baseDir The base pathname within pathname
     */
    public function addFileFromBasedir($pathname, $basedir = '')
    {
        $info = new \SplFileInfo($pathname);

        if (!$info->isFile())
        {
            throw new InvalidArgumentException(sprintf('File not found: %s', $pathname));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('File not readable: %s', $pathname));
        }

        $relativePathname = $this->subtractBasedir($pathname, $basedir);
        #echo sprintf("%s\n", $relativePathname);

        if ($basedir && $pathname === '/' . $relativePathname)
        {
            throw new InvalidArgumentException(sprintf('Invalid basedir: %s', $basedir));
        }

        $this->zip->addFile($pathname, $relativePathname);
    }

    /**
     * Calculate relative pathname within archive and create directory (does not overwrite existing)
     *
     * @example Pathname of '/share/lib/some/empty/dir' and basedir of '/share' will add 'lib/some/empty/dir' to archive
     *
     * @param string $pathname The full pathname
     * @param string $baseDir The base pathname within pathname
     */
    public function addEmptyDirFromBasedir($pathname, $basedir = '')
    {
        $info = new \SplFileInfo($pathname);

        if (!$info->isDir())
        {
            throw new InvalidArgumentException(sprintf('Dir not found: %s', $pathname));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('Dir not readable: %s', $pathname));
        }

        $relativePathname = $this->subtractBasedir($pathname, $basedir);

        if ($basedir && $pathname === '/' . $relativePathname)
        {
            throw new InvalidArgumentException(sprintf('Invalid basedir: %s', $basedir));
        }

        $parts = explode('/', $relativePathname);
        $currentSubDir = '';

        foreach($parts as $i => $part)
        {
            $currentSubDir = ltrim(sprintf('%s/%s', $currentSubDir, $part), '/');
            $currentDir = sprintf('%s/%s', $basedir, $currentSubDir);
            $this->zip->addEmptyDir($currentSubDir);
        }
    }

    /**
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