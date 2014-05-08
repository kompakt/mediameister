<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer\Event;

use Kompakt\Mediameister\EventDispatcher\Event;

class BatchStartErrorEvent extends Event
{
    protected $exception = null;

    public function __construct(\Exception $exception)
    {
        $this->exception = $exception;
    }
    
    public function getException()
    {
        return $this->exception;
    }
}