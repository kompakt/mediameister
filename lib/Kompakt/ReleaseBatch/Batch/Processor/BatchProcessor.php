<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Batch\Processor;

use Kompakt\ReleaseBatch\Batch\BatchInterface;
use Kompakt\ReleaseBatch\Batch\Filter\PackshotFilterInterface;
use Kompakt\ReleaseBatch\Batch\Processor\BatchProcessorInterface;
use Kompakt\ReleaseBatch\Batch\Processor\Event\BatchEndEvent;
use Kompakt\ReleaseBatch\Batch\Processor\Event\BatchErrorEvent;
use Kompakt\ReleaseBatch\Batch\Processor\Event\BatchStartEvent;
use Kompakt\ReleaseBatch\Batch\Processor\Event\Events;
use Kompakt\ReleaseBatch\Batch\Processor\Event\PackshotReadErrorEvent;
use Kompakt\ReleaseBatch\Batch\Processor\Event\PackshotReadEvent;
use Kompakt\ReleaseBatch\Batch\Processor\Event\PackshotReadOkEvent;
use Kompakt\ReleaseBatch\Timer\Timer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BatchProcessor implements BatchProcessorInterface
{
    protected $dispatcher = null;
    protected $batch = null;

    public function __construct(EventDispatcherInterface $dispatcher, BatchInterface $batch)
    {
        $this->dispatcher = $dispatcher;
        $this->batch = $batch;
    }

    public function process(PackshotFilterInterface $packshotFilter = null)
    {
        $timer = new Timer();
        $timer->start();

        try {
            if (function_exists('pcntl_signal'))
            {
                $handleSig = function() use ($timer)
                {
                    $event = new BatchEndEvent($timer->stop());
                    $this->dispatcher->dispatch(Events::BATCH_END, $event);
                };

                pcntl_signal(SIGTERM, $handleSig);
            }

            $event = new BatchStartEvent();
            $this->dispatcher->dispatch(Events::BATCH_START, $event);
        }
        catch (\Exception $e)
        {
            $event = new BatchErrorEvent($timer->stop(), $e);
            $this->dispatcher->dispatch(Events::BATCH_ERROR, $event);
        }

        foreach($this->batch->getPackshots($packshotFilter) as $packshot)
        {
            try {
                // make sure it's loaded or throws loading exception here
                $packshot->getRelease(); // todo: remove temporal coupling

                $event = new PackshotReadEvent($packshot);
                $this->dispatcher->dispatch(Events::PACKSHOT_READ, $event);

                $event = new PackshotReadOkEvent($packshot);
                $this->dispatcher->dispatch(Events::PACKSHOT_READ_OK, $event);
            }
            catch (\Exception $e)
            {
                $event = new PackshotReadErrorEvent($packshot, $e);
                $this->dispatcher->dispatch(Events::PACKSHOT_READ_ERROR, $event);
            }
        }

        try {
            $event = new BatchEndEvent($timer->stop());
            $this->dispatcher->dispatch(Events::BATCH_END, $event);
        }
        catch (\Exception $e)
        {
            $event = new BatchErrorEvent($timer->stop(), $e);
            $this->dispatcher->dispatch(Events::BATCH_ERROR, $event);
        }
    }
}