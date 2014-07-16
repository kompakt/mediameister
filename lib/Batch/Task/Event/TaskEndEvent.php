<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Event;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\Event;
use Kompakt\Mediameister\Util\Timer\Timer;

class TaskEndEvent extends Event
{
    protected $batch = null;
    protected $timer = null;

    public function __construct(BatchInterface $batch, Timer $timer)
    {
        $this->batch = $batch;
        $this->timer = $timer;
    }

    public function getBatch()
    {
        return $this->batch;
    }

    public function getTimer()
    {
        return $this->timer;
    }
}