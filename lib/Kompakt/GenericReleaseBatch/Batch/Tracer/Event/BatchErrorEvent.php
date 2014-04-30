<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Tracer\Event;

use Kompakt\GenericReleaseBatch\Timer\Timer;
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