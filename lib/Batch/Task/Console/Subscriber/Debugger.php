<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Console\Subscriber;

use Kompakt\Mediameister\Batch\Task\EventNamesInterface;
use Kompakt\Mediameister\Batch\Task\Event\PackshotErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\PackshotEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskEndEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskRunEvent;
use Kompakt\Mediameister\Batch\Task\Event\TrackErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TrackEvent;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Debugger
{
    protected $dispatcher = null;
    protected $eventNames = null;
    protected $output = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames,
        ConsoleOutputInterface $output
    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
        $this->output = $output;
    }

    public function activate()
    {
        $this->handleListeners(true);
    }

    public function deactivate()
    {
        $this->handleListeners(false);
    }

    protected function handleListeners($add)
    {
        $method = ($add) ? 'addListener' : 'removeListener';

        $this->dispatcher->$method(
            $this->eventNames->taskRun(),
            [$this, 'onTaskRun']
        );

        $this->dispatcher->$method(
            $this->eventNames->taskRunError(),
            [$this, 'onTaskRunError']
        );

        $this->dispatcher->$method(
            $this->eventNames->taskEnd(),
            [$this, 'onTaskEnd']
        );

        $this->dispatcher->$method(
            $this->eventNames->taskEndError(),
            [$this, 'onTaskEndError']
        );

        $this->dispatcher->$method(
            $this->eventNames->packshotLoadOk(),
            [$this, 'onPackshotLoadOk']
        );

        $this->dispatcher->$method(
            $this->eventNames->packshotLoadError(),
            [$this, 'onPackshotLoadError']
        );

        $this->dispatcher->$method(
            $this->eventNames->packshotUnload(),
            [$this, 'onPackshotUnload']
        );

        $this->dispatcher->$method(
            $this->eventNames->packshotUnloadError(),
            [$this, 'onPackshotUnloadError']
        );

        $this->dispatcher->$method(
            $this->eventNames->track(),
            [$this, 'onTrack']
        );

        $this->dispatcher->$method(
            $this->eventNames->trackError(),
            [$this, 'onTrackError']
        );
    }

    public function onTaskRun(TaskRunEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<info>+ DEBUG: Task run</info>'
            )
        );
    }

    public function onTaskRunError(TaskRunErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<error>+ DEBUG: Task run error %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onTaskEnd(TaskEndEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<info>+ DEBUG: Task end</info>'
            )
        );
    }

    public function onTaskEndError(TaskEndErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<error>+ DEBUG: Task end error %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onPackshotLoadOk(PackshotEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <info>+ DEBUG: Packshot load ok (%s)</info>',
                $event->getPackshot()->getName()
            )
        );
    }

    public function onPackshotLoadError(PackshotErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <error>! DEBUG: Packshot load error (%s): %s</error>',
                $event->getPackshot()->getName(),
                $event->getException()->getMessage()
            )
        );
    }

    public function onPackshotUnload(PackshotEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <info>+ DEBUG: Packshot unload (%s)</info>',
                $event->getPackshot()->getName()
            )
        );
    }

    public function onPackshotUnloadError(PackshotErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <error>! DEBUG: Packshot unload error (%s): %s</error>',
                $event->getPackshot()->getName(),
                $event->getException()->getMessage()
            )
        );
    }

    public function onTrack(TrackEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '    <info>+ DEBUG: Track</info>'
            )
        );
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '    <error>! DEBUG: Track error: %s</error>',
                $event->getException()->getMessage()
            )
        );
    }
}