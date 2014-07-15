<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Core\Batch;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Entity\TrackInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;
use Kompakt\Mediameister\Task\Core\Batch\EventNamesInterface;
use Kompakt\Mediameister\Task\Core\Batch\Event\PackshotErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\PackshotEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskEndEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskRunEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TrackErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TrackEvent;
use Kompakt\Mediameister\Task\Core\Batch\Exception\RuntimeException;
use Kompakt\Mediameister\Util\Timer\Timer;

class BatchTaskEngine
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
            throw new RuntimeException(sprintf('Batch task engine error'), null, $e);
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
                $this->eventNames->packshotLoad(),
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