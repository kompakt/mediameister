<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Batch\Processor\Event;

use Kompakt\ReleaseBatch\Timer\Timer;
use Symfony\Component\EventDispatcher\Event;

class BatchErrorEvent extends Event
{
    protected $timer = null;
    protected $exception = null;

    public function __construct(Timer $timer, \Exception $exception)
    {
        $this->timer = $timer;
        $this->exception = $exception;
    }

    public function getTimer()
    {
        return $this->timer;
    }

    public function getException()
    {
        return $this->exception;
    }
}