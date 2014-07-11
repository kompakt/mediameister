<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Concrete\Selection\Copier\Manager;

use Kompakt\Mediameister\Batch\Selection\Factory\SelectionFactory;
use Kompakt\Mediameister\DropDir\DropDir;
use Kompakt\Mediameister\Task\Concrete\Selection\Copier\Manager\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Util\Filesystem\Factory\ChildFileNamerFactory;

class TaskManager
{
    protected $selectionFactory = null;
    protected $childFileNamerFactory = null;
    protected $dropDir = null;
    protected $targetDropDir = null;

    public function __construct(
        SelectionFactory $selectionFactory,
        ChildFileNamerFactory $childFileNamerFactory,
        DropDir $dropDir,
        DropDir $targetDropDir
    )
    {
        $this->selectionFactory = $selectionFactory;
        $this->childFileNamerFactory = $childFileNamerFactory;
        $this->dropDir = $dropDir;
        $this->targetDropDir = $targetDropDir;
    }

    public function copy($batchName)
    {
        $batch = $this->dropDir->getBatch($batchName);

        if (!$batch)
        {
            throw new InvalidArgumentException(sprintf('Batch does not exist: "%s"', $batchName));
        }

        $fileNamer = $this->childFileNamerFactory->getInstance($this->targetDropDir->getDir());
        $name = $fileNamer->make($batch->getName());

        $selection = $this->selectionFactory->getInstance($batch);
        $selection->copy($this->targetDropDir, $name);
    }
}