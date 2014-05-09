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
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadOkEvent;
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
                    $packshot->load();

                    $this->dispatcher->dispatch(
                        $this->eventNames->packshotLoad(),
                        new PackshotLoadEvent($packshot)
                    );

                    $this->dispatcher->dispatch(
                        $this->eventNames->packshotLoadOk(),
                        new PackshotLoadOkEvent($packshot)
                    );
                }
                catch (\Exception $e)
                {
                    $this->dispatcher->dispatch(
                        $this->eventNames->packshotLoadError(),
                        new PackshotLoadErrorEvent($packshot, $e)
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