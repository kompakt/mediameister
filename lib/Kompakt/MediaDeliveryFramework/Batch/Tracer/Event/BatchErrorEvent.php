<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Tracer\Event;

use Kompakt\MediaDeliveryFramework\Timer\Timer;
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