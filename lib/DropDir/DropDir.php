<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\DropDir;

use Kompakt\Mediameister\Batch\Factory\BatchFactoryInterface;
use Kompakt\Mediameister\DropDir\DropDirInterface;
use Kompakt\Mediameister\DropDir\Exception\InvalidArgumentException;
use Kompakt\Mediameister\DropDir\Filter\BatchFilterInterface;
use Kompakt\Mediameister\Util\Filesystem\Directory;

class DropDir implements DropDirInterface
{
    protected $dir = null;
    protected $batchFactory = null;

    public function __construct(BatchFactoryInterface $batchFactory, $dir)
    {
        $info = new \SplFileInfo($dir);
        
        if (!$info->isDir())
        {
            throw new InvalidArgumentException(sprintf('Brop dir not found'));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('Brop dir not readable'));
        }

        if (!$info->isWritable())
        {
            throw new InvalidArgumentException(sprintf('Brop dir not writable'));
        }

        $this->batchFactory = $batchFactory;
        $this->dir = $dir;
    }

    public function getBatches(BatchFilterInterface $filter = null)
    {
        $batches = array();

        foreach (new \DirectoryIterator($this->dir) as $fileInfo)
        {
            if ($fileInfo->isDot() || !$fileInfo->isDir())
            {
                continue;
            }

            $batch = $this->batchFactory->getInstance($fileInfo->getPathname());

            if ($filter && (!$filter->add($batch) || $filter->ignore($batch)))
            {
                continue;
            }

            $batches[] = $batch;
        }

        return $batches;
    }

    public function getBatch($name)
    {
        $pathname = sprintf('%s/%s', $this->dir, $this->checkName($name));
        $fileInfo = new \SplFileInfo($pathname);

        if ($fileInfo->isDir())
        {
            return $this->batchFactory->getInstance($pathname);
        }

        return null;
    }

    public function createBatch($name)
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

        return $this->batchFactory->getInstance($dir);
    }

    public function deleteBatch($name)
    {
        $batch = $this->getBatch($name);

        if ($batch)
        {
            $directory = new Directory($batch->getDir());
            $directory->delete();
        }
    }

    protected function checkName($name)
    {
        if (preg_match('/(\.\.)?\//', $name))
        {
            throw new InvalidArgumentException(sprintf('Invalid batch name: "%s"', $name));
        }

        return $name;
    }
}