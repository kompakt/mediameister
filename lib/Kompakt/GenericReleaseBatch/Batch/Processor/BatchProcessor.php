<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Processor;

use Kompakt\GenericReleaseBatch\Batch\BatchInterface;
use Kompakt\GenericReleaseBatch\Batch\Filter\PackshotFilterInterface;
use Kompakt\GenericReleaseBatch\Batch\Processor\BatchProcessorInterface;
use Kompakt\GenericReleaseBatch\Batch\Processor\Event\BatchEndEvent;
use Kompakt\GenericReleaseBatch\Batch\Processor\Event\BatchErrorEvent;
use Kompakt\GenericReleaseBatch\Batch\Processor\Event\BatchStartEvent;
use Kompakt\GenericReleaseBatch\Batch\Processor\Event\Events;
use Kompakt\GenericReleaseBatch\Batch\Processor\Event\PackshotReadErrorEvent;
use Kompakt\GenericReleaseBatch\Batch\Processor\Event\PackshotReadEvent;
use Kompakt\GenericReleaseBatch\Batch\Processor\Event\PackshotReadOkEvent;
use Kompakt\GenericReleaseBatch\Timer\Timer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BatchProcessor implements BatchProcessorInterface
{
    protected $dispatcher = null;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function process(BatchInterface $batch, PackshotFilterInterface $packshotFilter = null)
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

        foreach($batch->getPackshots($packshotFilter) as $packshot)
        {
            try {
                // make sure it's loaded or throws loading exception here
                #$packshot->getRelease(); // todo: remove temporal coupling

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