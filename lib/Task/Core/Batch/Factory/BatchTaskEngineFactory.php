<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Core\Batch\Factory;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\Task\Core\Batch\BatchTaskEngine;
use Kompakt\Mediameister\Task\Core\Batch\EventNamesInterface;
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