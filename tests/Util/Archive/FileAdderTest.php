<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Util\Archive;

use Kompakt\Mediameister\Util\Archive\FileAdder;

class FileAdderTest extends \PHPUnit_Framework_TestCase
{
    public function testAddChildren()
    {
        $targetDir = $this->getTmpDir(__METHOD__);
        $sourceFilesDirname = sprintf('%s/_files/FileAdderTest/some-files', __DIR__);
        $zipPathname = sprintf('%s/%s.zip', $targetDir, basename($sourceFilesDirname));

        $zip = new \ZipArchive();
        $zip->open($zipPathname, \ZIPARCHIVE::CREATE);

        $fileAdder = new FileAdder($zip);
        $fileAdder->addChildren($sourceFilesDirname);

        $zip->close();
    }

    public function testAddFileFromBasedir()
    {
        $targetDir = $this->getTmpDir(__METHOD__);
        $sourceFilesDirname = sprintf('%s/_files/FileAdderTest/some-files', __DIR__);
        $zipPathname = sprintf('%s/%s.zip', $targetDir, basename($sourceFilesDirname));
        $pathnames = $this->getFiles($sourceFilesDirname);

        $zip = new \ZipArchive();
        $zip->open($zipPathname, \ZIPARCHIVE::CREATE);

        $fileAdder = new FileAdder($zip);

        foreach($pathnames as $pathname)
        {
            $fileAdder->addFileFromBasedir($pathname, $sourceFilesDirname);
        }

        $zip->close();
    }

    public function testEmptyDirFileFromBasedir()
    {
        $targetDir = $this->getTmpDir(__METHOD__);
        $sourceFilesDirname = sprintf('%s/_files/FileAdderTest/some-files', __DIR__);
        $zipPathname = sprintf('%s/%s.zip', $targetDir, basename($sourceFilesDirname));
        $pathnames = $this->getDirs($sourceFilesDirname);
        
        $zip = new \ZipArchive();
        $zip->open($zipPathname, \ZIPARCHIVE::CREATE);

        $fileAdder = new FileAdder($zip);

        foreach($pathnames as $pathname)
        {
            $fileAdder->addEmptyDirFromBasedir($pathname, $sourceFilesDirname);
        }

        $zip->close();
    }

    protected function getTmpDir($class)
    {
        $tmpDir = getTmpDir();
        return $tmpDir->replaceSubDir($tmpDir->prepareSubDirPath($class));
    }

    protected function getFiles($sourceFilesDirname)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($sourceFilesDirname, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        $pathnames = array();

        foreach($files as $info)
        {
            if (!$info->isFile())
            {
                continue;
            }

            $pathnames[] = $info->getPathname();
        }

        return $pathnames;
    }

    protected function getDirs($sourceFilesDirname)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($sourceFilesDirname, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        $pathnames = array();

        foreach($files as $info)
        {
            if ($info->isFile())
            {
                continue;
            }

            $pathnames[] = $info->getPathname();
        }

        return $pathnames;
    }
}