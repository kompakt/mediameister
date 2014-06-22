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
use Kompakt\Mediameister\Util\Filesystem\Factory\ChildFileNamerFactory;
use Kompakt\Mediameister\Util\Filesystem\Factory\DirectoryFactory;

class Selection
{
    protected $file = null;
    protected $directoryFactory = null;
    protected $childFileNamerFactory = null;
    protected $batch = null;

    public function __construct(
        FileFactory $fileFactory,
        DirectoryFactory $directoryFactory,
        ChildFileNamerFactory $childFileNamerFactory,
        BatchInterface $batch
    )
    {
        $this->file = $fileFactory->getInstance($batch->getDir());
        $this->directoryFactory = $directoryFactory;
        $this->childFileNamerFactory = $childFileNamerFactory;
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
        $fileNamer = $this->childFileNamerFactory->getInstance($targetDropDir->getDir());
        $name = $fileNamer->make($this->batch->getName());
        $targetBatch = $targetDropDir->createBatch($name);
        $fileNamer = $this->childFileNamerFactory->getInstance($targetBatch->getDir());

        foreach($this->getPackshots() as $packshot)
        {
            $name = $fileNamer->make($packshot->getName());
            $targetPackshot = $targetBatch->createPackshot($name);

            $directory = $this->directoryFactory->getInstance($packshot->getDir());
            $directory->copyChildren($targetPackshot->getDir());
        }
    }

    public function move(DropDirInterface $targetDropDir)
    {
        $fileNamer = $this->childFileNamerFactory->getInstance($targetDropDir->getDir());
        $name = $fileNamer->make($this->batch->getName());
        $targetBatch = $targetDropDir->createBatch($name);
        $fileNamer = $this->childFileNamerFactory->getInstance($targetBatch->getDir());

        foreach($this->getPackshots() as $packshot)
        {
            $name = $fileNamer->make($packshot->getName());
            $targetPackshot = $targetBatch->createPackshot($name);

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