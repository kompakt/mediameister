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
use Kompakt\Mediameister\DropDir\DropDirInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;
use Kompakt\Mediameister\Util\Filesystem\Directory;

class Selection
{
    protected $batch = null;
    protected $file = null;

    public function __construct(FileFactory $fileFactory, BatchInterface $batch)
    {
        $this->batch = $batch;
        $this->file = $fileFactory->getInstance($batch->getDir());
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

    public function copy(DropDirInterface $targetDropDir)
    {
        $targetBatch = $targetDropDir->createBatch($this->batch->getName());

        foreach($this->getPackshots() as $packshot)
        {
            $targetPackshot = $targetBatch->createPackshot($packshot->getName());

            $directory = new Directory($packshot->getDir());
            $directory->copyChildren($targetPackshot->getDir());
        }
    }

    public function move(DropDirInterface $targetDropDir)
    {
        $targetBatch = $targetDropDir->createBatch($this->batch->getName());

        foreach($this->getPackshots() as $packshot)
        {
            $targetPackshot = $targetBatch->createPackshot($packshot->getName());

            $directory = new Directory($packshot->getDir());
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