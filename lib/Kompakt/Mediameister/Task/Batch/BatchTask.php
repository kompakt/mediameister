<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch;

use Kompakt\Mediameister\DropDir\DropDirInterface;
use Kompakt\Mediameister\DropDir\Registry\RegistryInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\Task\Batch\EventNamesInterface;
use Kompakt\Mediameister\Task\Batch\Event\ArtworkErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\ArtworkEvent;
use Kompakt\Mediameister\Task\Batch\Event\BatchEndEvent;
use Kompakt\Mediameister\Task\Batch\Event\BatchEndErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\BatchStartEvent;
use Kompakt\Mediameister\Task\Batch\Event\BatchStartErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\InputErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\MetadataErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\MetadataEvent;
use Kompakt\Mediameister\Task\Batch\Event\PackshotLoadErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\PackshotLoadEvent;
use Kompakt\Mediameister\Task\Batch\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\TaskEndEvent;
use Kompakt\Mediameister\Task\Batch\Event\TaskFinalEvent;
use Kompakt\Mediameister\Task\Batch\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\TaskRunEvent;
use Kompakt\Mediameister\Task\Batch\Event\TrackErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\TrackEvent;
use Kompakt\Mediameister\Task\Batch\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Task\Batch\Exception\RuntimeException;
use Kompakt\Mediameister\Util\Timer\Timer;

class BatchTask
{
    protected $dispatcher = null;
    protected $eventNames = null;
    protected $dropDirRegistry = null;
    protected $requireTargetDropDir = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames,
        RegistryInterface $dropDirRegistry,
        $requireTargetDropDir = true
    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
        $this->dropDirRegistry = $dropDirRegistry;
        $this->requireTargetDropDir = (bool) $requireTargetDropDir;
    }

    public function run($sourceDropDirLabel, $sourceBatchName, $targetDropDirLabel = null)
    {
        try {
            $this->doRun($sourceDropDirLabel, $sourceBatchName, $targetDropDirLabel);
        }
        catch (\Exception $e)
        {
            throw new RuntimeException(sprintf('Task error: "%s', $e->getMessage()), null, $e);
        }
    }

    protected function doRun($sourceDropDirLabel, $sourceBatchName, $targetDropDirLabel)
    {
        $timer = new Timer();
        $timer->start();
        $targetDropDir = null;
        $sourceDropDir = $this->getSourceDropDir($sourceDropDirLabel);

        if (!$sourceDropDir)
        {
            return;
        }

        $sourceBatch = $this->getSourceBatch($sourceDropDir, $sourceBatchName);

        if (!$sourceBatch)
        {
            return;
        }

        if ($this->requireTargetDropDir)
        {
            $targetDropDir = $this->getTargetDropDir($targetDropDirLabel);

            if (!$targetDropDir)
            {
                return;
            }
        }

        if (!$this->runTask($sourceBatch, $targetDropDir))
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

        foreach($sourceBatch->getPackshots() as $packshot)
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

    protected function getSourceDropDir($sourceDropDirLabel)
    {
        try {
            $sourceDropDir = $this->dropDirRegistry->get($sourceDropDirLabel);

            if ($sourceDropDir)
            {
                return $sourceDropDir;
            }

            throw new InvalidArgumentException(sprintf('Source drop dir "%s" not found', $sourceDropDirLabel));
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->inputError(),
                new InputErrorEvent($e)
            );

            return null;
        }
    }

    protected function getSourceBatch($sourceDropDir, $sourceBatchName)
    {
        try {
            $sourceBatch = $sourceDropDir->getBatch($sourceBatchName);

            if ($sourceBatch)
            {
                return $sourceBatch;
            }

            throw new InvalidArgumentException(sprintf('Source batch "%s" not found', $sourceBatchName));
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->inputError(),
                new InputErrorEvent($e)
            );

            return null;
        }
    }

    protected function getTargetDropDir($targetDropDirLabel)
    {
        try {
            $targetDropDir = $this->dropDirRegistry->get($targetDropDirLabel);

            if ($targetDropDir)
            {
                return $targetDropDir;
            }

            throw new InvalidArgumentException(sprintf('Target drop dir "%s" not found', $targetDropDirLabel));
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->inputError(),
                new InputErrorEvent($e)
            );

            return null;
        }
    }

    protected function runTask($sourceBatch, $targetDropDir)
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->taskRun(),
                new TaskRunEvent($sourceBatch, $targetDropDir)
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

    protected function endTask($timer)
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

    protected function loadPackshot($packshot)
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

    protected function handleTrack($track)
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