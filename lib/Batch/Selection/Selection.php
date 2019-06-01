<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Selection;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Selection\Factory\FileFactory;
use Kompakt\Mediameister\Packshot\PackshotInterface;
use Kompakt\Mediameister\Util\Filesystem\Factory\DirectoryFactory;

class Selection
{
    protected $file = null;
    protected $directoryFactory = null;
    protected $batch = null;

    public function __construct(
        FileFactory $fileFactory,
        DirectoryFactory $directoryFactory,
        BatchInterface $batch
    )
    {
        $this->file = $fileFactory->getInstance($batch->getDir());
        $this->directoryFactory = $directoryFactory;
        $this->batch = $batch;
    }

    public function getPackshots()
    {
        $packshots = array();

        foreach($this->file->getItems() as $item)
        {
            $packshot = $this->batch->getPackshot($item);

            if ($packshot)
            {
                $packshots[] = $packshot;
            }
        }

        return $packshots;
    }

    public function getPackshot($name)
    {
        foreach($this->file->getItems() as $item)
        {
            $packshot = $this->batch->getPackshot($item);

            if ($packshot)
            {
                return $packshot;
            }
        }

        return null;
    }

    public function hasPackshot($name)
    {
        return ($this->getPackshot($name));
    }

    public function addPackshot(PackshotInterface $packshot)
    {
        $this->addPackshots(array($packshot));
    }

    public function addPackshots(array $packshots)
    {
        $names = array();

        foreach($packshots as $packshot)
        {
            $names[] = $packshot->getName();
        }

        $this->file->addItems($names);
    }

    public function removePackshot(PackshotInterface $packshot)
    {
        $this->removePackshots(array($packshot));
    }

    public function removePackshots(array $packshots)
    {
        $names = array();

        foreach($packshots as $packshot)
        {
            $names[] = $packshot->getName();
        }

        $this->file->removeItems($names);
    }

    public function clear()
    {
        $this->file->clear();
    }

    public function segregateCopy(BatchInterface $targetBatch)
    {
        foreach($this->getPackshots() as $packshot)
        {
            $targetPackshot = $targetBatch->createPackshot($packshot->getName());
            $directory = $this->directoryFactory->getInstance($packshot->getDir());
            $directory->copyChildren($targetPackshot->getDir());
        }
    }

    public function segregateMove(BatchInterface $targetBatch)
    {
        foreach($this->getPackshots() as $packshot)
        {
            $targetPackshot = $targetBatch->createPackshot($packshot->getName());
            $directory = $this->directoryFactory->getInstance($packshot->getDir());
            $directory->moveChildren($targetPackshot->getDir());
            rmdir($packshot->getDir());
        }

        $this->clear();
    }

    public function delete()
    {
        foreach($this->getPackshots() as $packshot)
        {
            $this->batch->deletePackshot($packshot->getName());
        }

        $this->clear();
    }
}