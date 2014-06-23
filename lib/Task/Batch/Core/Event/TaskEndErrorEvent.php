<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Core\Event;

use Kompakt\Mediameister\Generic\EventDispatcher\Event;
use Kompakt\Mediameister\Util\Timer\Timer;

class TaskEndErrorEvent extends Event
{
    protected $exception = null;
    protected $timer = null;

    public function __construct(\Exception $exception, Timer $timer)
    {
        $this->exception = $exception;
        $this->timer = $timer;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function getTimer()
    {
        return $this->timer;
    }
}