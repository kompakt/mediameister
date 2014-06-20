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

class SelectionFactory
{
    protected $fileFactory = null;

    public function __construct(FileFactory $fileFactory)
    {
        $this->fileFactory = $fileFactory;
    }

    public function getInstance(BatchInterface $batch)
    {
        return new Selection($this->fileFactory, $batch);
    }
}