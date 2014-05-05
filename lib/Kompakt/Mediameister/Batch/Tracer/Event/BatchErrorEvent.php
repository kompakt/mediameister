<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer\Event;

use Kompakt\Mediameister\Timer\Timer;
use Kompakt\Mediameister\EventDispatcher\Event;

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