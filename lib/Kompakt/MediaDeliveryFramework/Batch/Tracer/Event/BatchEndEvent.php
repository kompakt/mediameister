<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Tracer\Event;

use Kompakt\MediaDeliveryFramework\Timer\Timer;
use Kompakt\MediaDeliveryFramework\EventDispatcher\EventInterface;

class BatchEndEvent implements EventInterface
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