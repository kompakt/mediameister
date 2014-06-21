<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Batch\Filter\PackshotFilterInterface;
use Kompakt\Mediameister\Packshot\Factory\PackshotFactoryInterface;
use Kompakt\Mediameister\Util\Filesystem\Directory;

class Batch implements BatchInterface
{
    protected $dir = null;
    protected $packshotFactory = null;

    public function __construct(PackshotFactoryInterface $packshotFactory, $dir)
    {
        $info = new \SplFileInfo($dir);

        if (!$info->isDir())
        {
            throw new InvalidArgumentException(sprintf('Batch dir not found'));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('Batch dir not readable'));
        }

        if (!$info->isWritable())
        {
            throw new InvalidArgumentException(sprintf('Batch dir not writable'));
        }
        
        $this->packshotFactory = $packshotFactory;
        $this->dir = $dir;
    }

    public function getDir()
    {
        return $this->dir;
    }

    public function getName()
    {
        return basename($this->dir);
    }

    public function getPackshots(PackshotFilterInterface $filter = null)
    {
        $packshots = array();

        foreach (new \DirectoryIterator($this->dir) as $fileInfo)
        {
            if ($fileInfo->isDot() || !$fileInfo->isDir())
            {
                continue;
            }

            $packshot = $this->packshotFactory->getInstance($fileInfo->getPathname());

            if ($filter && (!$filter->add($packshot) || $filter->ignore($packshot)))
            {
                continue;
            }

            $packshots[] = $packshot;
        }

        return $packshots;
    }

    public function getPackshot($name)
    {
        $pathname = sprintf('%s/%s', $this->dir, $this->checkName($name));
        $fileInfo = new \SplFileInfo($pathname);

        if ($fileInfo->isDir())
        {
            return $this->packshotFactory->getInstance($pathname);
        }

        return null;
    }

    public function createPackshot($name)
    {
        $baseDir = $dir = sprintf('%s/%s', $this->dir, $this->checkName($name));
        $count = 1;
        $created = false;

        while (!$created)
        {
            $fileInfo = new \SplFileInfo($dir);

            if ($fileInfo->isDir())
            {
                $dir = sprintf('%s-%s', $baseDir, $count++);
            }
            else {
                mkdir($dir, 0777);
                $created = true;
            }
        }

        return $this->packshotFactory->getInstance($dir);
    }

    public function deletePackshot($name)
    {
        $packshot = $this->getPackshot($name);

        if ($packshot)
        {
            $directory = new Directory($packshot->getDir());
            $directory->delete();
        }
    }

    protected function checkName($name)
    {
        if (preg_match('/(\.\.)?\//', $name))
        {
            throw new InvalidArgumentException(sprintf('Invalid packshot name: "%s"', $name));
        }

        return $name;
    }
}