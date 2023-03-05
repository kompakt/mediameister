<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Task\EventNamesInterface;
use Kompakt\Mediameister\Batch\Task\Event\PackshotErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\PackshotEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskEndEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskRunEvent;
use Kompakt\Mediameister\Batch\Task\Event\TrackErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TrackEvent;
use Kompakt\Mediameister\Batch\Task\Exception\RuntimeException;
use Kompakt\Mediameister\Entity\TrackInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;
use Kompakt\Mediameister\Util\Timer\Timer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Task
{
    protected $dispatcher = null;
    protected $eventNames = null;
    protected $timer = null;
    protected $batch = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames,
        Timer $timer,
        BatchInterface $batch
    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
        $this->timer = $timer;
        $this->batch = $batch;
    }

    public function start()
    {
        try {
            $this->timer->start();

            if (!$this->runTask())
            {
                $this->endTask();
                return;
            }

            foreach($this->batch->getPackshots() as $packshot)
            {
                if (!$this->loadPackshot($packshot))
                {
                    continue;
                }

                foreach ($packshot->getRelease()->getTracks() as $track)
                {
                    $this->handleTrack($packshot, $track);
                }

                $this->unloadPackshot($packshot);
            }

            $this->endTask();
        }
        catch (\Exception $e)
        {
            throw new RuntimeException(sprintf('Batch task error'), 0, $e);
        }
    }

    protected function runTask()
    {
        try {
            $this->dispatcher->dispatch(
                new TaskRunEvent($this->batch),
                $this->eventNames->taskRun()
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                new TaskRunErrorEvent($e, $this->batch),
                $this->eventNames->taskRunError()
            );

            return false;
        }
    }

    protected function endTask()
    {
        try {
            $this->dispatcher->dispatch(
                new TaskEndEvent($this->batch, $this->timer->stop()),
                $this->eventNames->taskEnd()
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                new TaskEndErrorEvent($e, $this->batch, $this->timer->stop()),
                $this->eventNames->taskEndError()
            );

            return false;
        }
    }

    protected function loadPackshot(PackshotInterface $packshot)
    {
        try {
            $packshot->load();

            $this->dispatcher->dispatch(
                new PackshotEvent($this->batch, $packshot),
                $this->eventNames->packshotLoadOk()
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                new PackshotErrorEvent($e, $this->batch, $packshot),
                $this->eventNames->packshotLoadError()
            );

            return false;
        }
    }

    protected function unloadPackshot(PackshotInterface $packshot)
    {
        try {
            $this->dispatcher->dispatch(
                new PackshotEvent($this->batch, $packshot),
                $this->eventNames->packshotUnload()
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                new PackshotErrorEvent($e, $this->batch, $packshot),
                $this->eventNames->packshotUnloadError()
            );

            return false;
        }
    }

    protected function handleTrack(PackshotInterface $packshot, TrackInterface $track)
    {
        try {
            $this->dispatcher->dispatch(
                new TrackEvent($this->batch, $packshot, $track),
                $this->eventNames->track()
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                new TrackErrorEvent($e, $this->batch, $packshot, $track),
                $this->eventNames->trackError()
            );

            return false;
        }
    }
}