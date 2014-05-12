<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\BatchTracker\Event;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\DropDir\DropDirInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\Event;

class TaskRunEvent extends Event
{
    protected $sourceBatch = null;
    protected $targetDropDir = null;

    public function __construct(BatchInterface $sourceBatch, DropDirInterface $targetDropDir = null)
    {
        $this->sourceBatch = $sourceBatch;
        $this->targetDropDir = $targetDropDir;
    }

    public function getSourceBatch()
    {
        return $this->sourceBatch;
    }

    public function getTargetDropDir()
    {
        return $this->targetDropDir;
    }
}