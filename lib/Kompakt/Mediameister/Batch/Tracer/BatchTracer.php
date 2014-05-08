<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Filter\PackshotFilterInterface;
use Kompakt\Mediameister\Batch\Tracer\BatchTracerInterface;
use Kompakt\Mediameister\Batch\Tracer\EventNamesInterface;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchEndEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchEndErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchEndOkEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartOkEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotReadErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotReadEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotReadOkEvent;
use Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface;

class BatchTracer implements BatchTracerInterface
{
    protected $dispatcher = null;
    protected $eventNames = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames
    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
    }

    public function trace(BatchInterface $batch, PackshotFilterInterface $packshotFilter = null)
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->batchStart(),
                new BatchStartEvent()
            );

            $this->dispatcher->dispatch(
                $this->eventNames->batchStartOk(),
                new BatchStartOkEvent()
            );

            foreach($batch->getPackshots($packshotFilter) as $packshot)
            {
                try {
                    // throws loading exception here if required
                    $packshot->load();

                    $this->dispatcher->dispatch(
                        $this->eventNames->packshotRead(),
                        new PackshotReadEvent($packshot)
                    );

                    $this->dispatcher->dispatch(
                        $this->eventNames->packshotReadOk(),
                        new PackshotReadOkEvent($packshot)
                    );
                }
                catch (\Exception $e)
                {
                    $this->dispatcher->dispatch(
                        $this->eventNames->packshotReadError(),
                        new PackshotReadErrorEvent($packshot, $e)
                    );
                }
            }

            try {
                $this->dispatcher->dispatch(
                    $this->eventNames->batchEnd(),
                    new BatchEndEvent()
                );

                $this->dispatcher->dispatch(
                    $this->eventNames->batchEndOk(),
                    new BatchEndOkEvent()
                );
            }
            catch (\Exception $e)
            {
                $this->dispatcher->dispatch(
                    $this->eventNames->batchEndError(),
                    new BatchEndErrorEvent($e)
                );
            }
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->batchStartError(),
                new BatchStartErrorEvent($e)
            );
        }
    }
}