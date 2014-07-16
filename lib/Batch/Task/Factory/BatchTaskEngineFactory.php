<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Factory;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Task\BatchTaskEngine;
use Kompakt\Mediameister\Batch\Task\EventNamesInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\Util\Timer\Timer;

class BatchTaskEngineFactory
{
    protected $dispatcher = null;
    protected $eventNames = null;
    protected $timer = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames,
        Timer $timer
    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
        $this->timer = $timer;
    }

    public function getInstance(BatchInterface $batch)
    {
        return new BatchTaskEngine(
            $this->dispatcher,
            $this->eventNames,
            $this->timer,
            $batch
        );
    }
}