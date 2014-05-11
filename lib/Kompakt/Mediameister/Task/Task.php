<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task;

use Kompakt\Mediameister\Batch\Tracer\Event\BatchEndEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchEndErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadEvent;
use Kompakt\Mediameister\DropDir\DropDirInterface;
use Kompakt\Mediameister\DropDir\Registry\RegistryInterface;
use Kompakt\Mediameister\Component\Native\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\Packshot\Tracer\Event\ArtworkErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\ArtworkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\MetadataErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\MetadataEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackEvent;
use Kompakt\Mediameister\Task\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Task\Exception\RuntimeException;
use Kompakt\Mediameister\Task\Tracer\EventNamesInterface;
use Kompakt\Mediameister\Task\Tracer\Event\InputErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskEndEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskFinalEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskRunEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Util\Timer\Timer;

class Task
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
        $sourceBatch = null;
        $targetDropDir = null;
        $hasInputError = false;
        $hasTaskStartError = false;
        $hasBatchStartError = false;
        $timer = new Timer();
        $timer->start();

        if (function_exists('pcntl_signal'))
        {
            $handleSig = function() use ($timer)
            {
                $this->dispatcher->dispatch(
                    $this->eventNames->taskEnd(),
                    new TaskEndEvent($timer->stop())
                );
            };

            pcntl_signal(SIGTERM, $handleSig);
        }

        try {
            try {
                $sourceDropDir = $this->dropDirRegistry->get($sourceDropDirLabel);

                if (!$sourceDropDir)
                {
                    throw new InvalidArgumentException(sprintf('Source drop dir "%s" not found', $sourceDropDirLabel));
                }

                $sourceBatch = $sourceDropDir->getBatch($sourceBatchName);

                if (!$sourceBatch)
                {
                    $hasInputError = true;
                    throw new InvalidArgumentException(sprintf('Source batch "%s" not found', $sourceBatchName));
                }

                $targetDropDir = $this->dropDirRegistry->get($targetDropDirLabel);

                if (!$targetDropDir && $this->requireTargetDropDir)
                {
                    $hasInputError = true;
                    throw new InvalidArgumentException(sprintf('Target drop dir "%s" not found', $targetDropDirLabel));
                }
            }
            catch (\Exception $e)
            {
                $this->dispatcher->dispatch(
                    $this->eventNames->inputError(),
                    new InputErrorEvent($e)
                );
            }

            if ($hasInputError)
            {
                return;
            }

            try {
                $this->dispatcher->dispatch(
                    $this->eventNames->taskRun(),
                    new TaskRunEvent($sourceBatch, $targetDropDir)
                );
            }
            catch (\Exception $e)
            {
                $hasTaskStartError = true;

                $this->dispatcher->dispatch(
                    $this->eventNames->taskRunError(),
                    new TaskRunErrorEvent($e)
                );
            }

            if ($hasTaskStartError)
            {
                return;
            }

            try {
                $this->dispatcher->dispatch(
                    $this->eventNames->batchStart(),
                    new BatchStartEvent()
                );
            }
            catch (\Exception $e)
            {
                $hasBatchStartError = true;

                $this->dispatcher->dispatch(
                    $this->eventNames->batchStartError(),
                    new BatchStartErrorEvent($e)
                );
            }

            if ($hasBatchStartError)
            {
                return;
            }

            foreach($sourceBatch->getPackshots(/*$packshotFilter*/) as $packshot)
            {
                $this->tracePackshot($packshot);
            }

            try {
                $this->dispatcher->dispatch(
                    $this->eventNames->batchEnd(),
                    new BatchEndEvent()
                );
            }
            catch (\Exception $e)
            {
                $this->dispatcher->dispatch(
                    $this->eventNames->batchEndError(),
                    new BatchEndErrorEvent($e)
                );
            }

            try {
                $this->dispatcher->dispatch(
                    $this->eventNames->taskEnd(),
                    new TaskEndEvent($sourceBatch, $targetDropDir)
                );
            }
            catch (\Exception $e)
            {
                $this->dispatcher->dispatch(
                    $this->eventNames->taskEndError(),
                    new TaskEndErrorEvent($e)
                );
            }

            $this->dispatcher->dispatch(
                $this->eventNames->taskFinal(),
                new TaskFinalEvent($timer->stop())
            );
        }
        catch (\Exception $e)
        {
            // Probably a error event handler threw an exception...
            throw new RuntimeException(sprintf('Unknown error: "%s', $e->getMessage()), null, $e);
        }
    }

    protected function tracePackshot($packshot)
    {
        $hasLoadError = false;

        try {
            $packshot->load();

            $this->dispatcher->dispatch(
                $this->eventNames->packshotLoad(),
                new PackshotLoadEvent($packshot)
            );
        }
        catch (\Exception $e)
        {
            $hasLoadError = true;

            $this->dispatcher->dispatch(
                $this->eventNames->packshotLoadError(),
                new PackshotLoadErrorEvent($packshot, $e)
            );
        }

        if ($hasLoadError)
        {
            return;
        }

        try {
            $this->dispatcher->dispatch(
                $this->eventNames->artwork(),
                new ArtworkEvent()
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->artworkError(),
                new ArtworkErrorEvent($e)
            );
        }

        foreach ($packshot->getRelease()->getTracks() as $track)
        {
            $this->traceTrack($track);
        }

        try {
            $this->dispatcher->dispatch(
                $this->eventNames->metadata(),
                new MetadataEvent()
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->metadataError(),
                new MetadataErrorEvent($e)
            );
        }
    }

    protected function traceTrack($track)
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->track(),
                new TrackEvent($track)
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->trackError(),
                new TrackErrorEvent($track, $e)
            );
        }
    }
}