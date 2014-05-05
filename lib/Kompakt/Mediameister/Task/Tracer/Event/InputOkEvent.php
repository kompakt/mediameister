<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Tracer\Event;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\DropDir\DropDirInterface;
use Kompakt\Mediameister\EventDispatcher\Event;

class InputOkEvent extends Event
{
    protected $sourceBatch = null;
    protected $targetDropDir = null;

    public function __construct(BatchInterface $sourceBatch, DropDirInterface $targetDropDir)
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