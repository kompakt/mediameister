<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Tracer\Subscriber;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Tracer\BatchTracerInterface;
use Kompakt\Mediameister\Batch\Tracer\EventNamesInterface as BatchEventNamesInterface;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotReadOkEvent;
use Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Packshot\Tracer\PackshotTracerInterface;
use Kompakt\Mediameister\Task\Tracer\Event\InputOkEvent;
use Kompakt\Mediameister\Task\Tracer\EventNamesInterface as TaskEventNamesInterface;

class TracerStarter implements EventSubscriberInterface
{
    protected $dispatcher = null;
    protected $taskEventNames = null;
    protected $batchEventNames = null;
    protected $batchTracer = null;
    protected $packshotTracer = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        TaskEventNamesInterface $taskEventNames,
        BatchEventNamesInterface $batchEventNames,
        BatchTracerInterface $batchTracerPrototype,
        PackshotTracerInterface $packshotTracerPrototype
    )
    {
        $this->dispatcher = $dispatcher;
        $this->taskEventNames = $taskEventNames;
        $this->batchEventNames = $batchEventNames;
        $this->batchTracer = clone $batchTracerPrototype;
        $this->packshotTracer = clone $packshotTracerPrototype;
    }

    public function getSubscriptions()
    {
        return array(
            $this->taskEventNames->inputOk() => array(
                array('onInputOk', 0)
            ),
            $this->batchEventNames->packshotReadOk() => array(
                array('onPackshotReadOk', 0)
            )
        );
    }

    public function onInputOk(InputOkEvent $event)
    {
        $this->batchTracer->trace($event->getSourceBatch());
    }

    public function onPackshotReadOk(PackshotReadOkEvent $event)
    {
        $this->packshotTracer->trace($event->getPackshot());
    }
}