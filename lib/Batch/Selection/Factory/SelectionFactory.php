<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Selection\Factory;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Selection\Factory\FileFactory;
use Kompakt\Mediameister\Batch\Selection\Selection;
use Kompakt\Mediameister\Util\Filesystem\Factory\DirectoryFactory;

class SelectionFactory
{
    protected $fileFactory = null;
    protected $directoryFactory = null;

    public function __construct(
        FileFactory $fileFactory,
        DirectoryFactory $directoryFactory
    )
    {
        $this->fileFactory = $fileFactory;
        $this->directoryFactory = $directoryFactory;
    }

    public function getInstance(BatchInterface $batch)
    {
        return new Selection(
            $this->fileFactory,
            $this->directoryFactory,
            $batch
        );
    }
}