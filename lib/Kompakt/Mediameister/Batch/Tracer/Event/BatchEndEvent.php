<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer\Event;

use Kompakt\Mediameister\Timer\Timer;
use Kompakt\Mediameister\EventDispatcher\EventInterface;

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