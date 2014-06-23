<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Core;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Entity\TrackInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;
use Kompakt\Mediameister\Task\Batch\Core\EventNamesInterface;
use Kompakt\Mediameister\Task\Batch\Core\Event\ArtworkErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\ArtworkEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\BatchEndEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\BatchEndErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\BatchStartEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\BatchStartErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\MetadataErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\MetadataEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\PackshotLoadErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\PackshotLoadEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\TaskEndEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\TaskRunEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\TrackErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\TrackEvent;
use Kompakt\Mediameister\Task\Batch\Core\Exception\RuntimeException;
use Kompakt\Mediameister\Util\Timer\Timer;

class BatchTask
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

    public function run(BatchInterface $batch)
    {
        try {
            $this->doRun($batch);
        }
        catch (\Exception $e)
        {
            throw new RuntimeException(sprintf('Task error: "%s', $e->getMessage()), null, $e);
        }
    }

    protected function doRun(BatchInterface $batch)
    {
        $timer = new Timer();
        $timer->start();

        if (!$this->runTask($batch))
        {
            $this->endTask($timer);
            return;
        }

        if (!$this->startBatch())
        {
            $this->endBatch();
            $this->endTask($timer);
            return;
        }

        foreach($batch->getPackshots() as $packshot)
        {
            if (!$this->loadPackshot($packshot))
            {
                continue;
            }

            $this->handleArtwork();

            foreach ($packshot->getRelease()->getTracks() as $track)
            {
                $this->handleTrack($track);
            }

            $this->handleMetadata();
        }

        $this->endBatch();
        $this->endTask($timer);
    }

    protected function runTask(BatchInterface $batch)
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->taskRun(),
                new TaskRunEvent($batch)
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->taskRunError(),
                new TaskRunErrorEvent($e)
            );

            return false;
        }
    }

    protected function endTask(Timer $timer)
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->taskEnd(),
                new TaskEndEvent($timer->stop())
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->taskEndError(),
                new TaskEndErrorEvent($e, $timer->stop())
            );

            return false;
        }
    }

    protected function startBatch()
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->batchStart(),
                new BatchStartEvent()
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->batchStartError(),
                new BatchStartErrorEvent($e)
            );

            return false;
        }
    }

    protected function endBatch()
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->batchEnd(),
                new BatchEndEvent()
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->batchEndError(),
                new BatchEndErrorEvent($e)
            );

            return false;
        }
    }

    protected function loadPackshot(PackshotInterface $packshot)
    {
        try {
            $packshot->load();

            $this->dispatcher->dispatch(
                $this->eventNames->packshotLoad(),
                new PackshotLoadEvent($packshot)
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->packshotLoadError(),
                new PackshotLoadErrorEvent($packshot, $e)
            );

            return false;
        }
    }

    protected function handleArtwork()
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->artwork(),
                new ArtworkEvent()
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->artworkError(),
                new ArtworkErrorEvent($e)
            );

            return false;
        }
    }

    protected function handleTrack(TrackInterface $track)
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->track(),
                new TrackEvent($track)
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->trackError(),
                new TrackErrorEvent($track, $e)
            );

            return false;
        }
    }

    protected function handleMetadata()
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->metadata(),
                new MetadataEvent()
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->metadataError(),
                new MetadataErrorEvent($e)
            );

            return false;
        }
    }
}