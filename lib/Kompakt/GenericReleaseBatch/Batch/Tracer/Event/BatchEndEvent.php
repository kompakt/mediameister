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

class BatchEndEvent extends Event
{
    protected $timer = null;

    public function __construct(Timer $timer)
    {
        $this->timer = $timer;
    }

    public function getTimer()
    {
        return $this->timer;
    }
}