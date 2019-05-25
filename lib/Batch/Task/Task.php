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
            throw new RuntimeException(sprintf('Batch task error'), null, $e);
        }
    }

    protected function runTask()
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->taskRun(),
                new TaskRunEvent($this->batch)
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->taskRunError(),
                new TaskRunErrorEvent($e, $this->batch)
            );

            return false;
        }
    }

    protected function endTask()
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->taskEnd(),
                new TaskEndEvent($this->batch, $this->timer->stop())
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->taskEndError(),
                new TaskEndErrorEvent($e, $this->batch, $this->timer->stop())
            );

            return false;
        }
    }

    protected function loadPackshot(PackshotInterface $packshot)
    {
        try {
            $packshot->load();

            $this->dispatcher->dispatch(
                $this->eventNames->packshotLoadOk(),
                new PackshotEvent($this->batch, $packshot)
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->packshotLoadError(),
                new PackshotErrorEvent($e, $this->batch, $packshot)
            );

            return false;
        }
    }

    protected function unloadPackshot(PackshotInterface $packshot)
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->packshotUnload(),
                new PackshotEvent($this->batch, $packshot)
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->packshotUnloadError(),
                new PackshotErrorEvent($e, $this->batch, $packshot)
            );

            return false;
        }
    }

    protected function handleTrack(PackshotInterface $packshot, TrackInterface $track)
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->track(),
                new TrackEvent($this->batch, $packshot, $track)
            );

            return true;
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->trackError(),
                new TrackErrorEvent($e, $this->batch, $packshot, $track)
            );

            return false;
        }
    }
}