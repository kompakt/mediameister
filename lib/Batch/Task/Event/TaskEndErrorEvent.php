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

class TaskEndErrorEvent extends Event
{
    protected $exception = null;
    protected $batch = null;
    protected $timer = null;

    public function __construct(\Exception $exception, BatchInterface $batch, Timer $timer)
    {
        $this->exception = $exception;
        $this->batch = $batch;
        $this->timer = $timer;
    }

    public function getException()
    {
        return $this->exception;
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