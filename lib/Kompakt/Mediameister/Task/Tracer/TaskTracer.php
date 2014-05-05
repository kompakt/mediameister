<?php

/*
 * This file is part of the kompakt/release-batch-tasks package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Tracer;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Tracer\BatchTracerInterface;
use Kompakt\Mediameister\Batch\Tracer\Event\Events as BatchEvents;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotReadOkEvent;
use Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Packshot\Tracer\PackshotTracerInterface;
use Kompakt\Mediameister\Task\Tracer\Event\Events as TaskEvents;
use Kompakt\Mediameister\Task\Tracer\Event\InputOkEvent;

class TaskTracer implements EventSubscriberInterface
{
    protected $dispatcher = null;
    protected $batchTracer = null;
    protected $packshotTracer = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        BatchTracerInterface $batchTracerPrototype,
        PackshotTracerInterface $packshotTracerPrototype
    )
    {
        $this->dispatcher = $dispatcher;
        $this->batchTracer = clone $batchTracerPrototype;
        $this->packshotTracer = clone $packshotTracerPrototype;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TaskEvents::INPUT_OK => array(
                array('onInputOk', 0)
            ),
            BatchEvents::PACKSHOT_READ_OK => array(
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