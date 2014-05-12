<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\BatchTracker\Event;

use Kompakt\Mediameister\Generic\EventDispatcher\Event;
use Kompakt\Mediameister\Util\Timer\Timer;

class TaskFinalEvent extends Event
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