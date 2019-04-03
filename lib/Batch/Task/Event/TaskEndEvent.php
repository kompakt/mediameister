<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Event;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Util\Timer\Timer;
use Symfony\Component\EventDispatcher\Event;

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