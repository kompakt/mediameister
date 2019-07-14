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
use Kompakt\Mediameister\Batch\Task\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TrackErrorEvent;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ErrorPrinter
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
            $this->eventNames->taskRunError(),
            [$this, 'onTaskRunError']
        );

        $this->dispatcher->$method(
            $this->eventNames->taskEndError(),
            [$this, 'onTaskEndError']
        );

        $this->dispatcher->$method(
            $this->eventNames->packshotLoadError(),
            [$this, 'onPackshotLoadError']
        );

        $this->dispatcher->$method(
            $this->eventNames->packshotUnloadError(),
            [$this, 'onPackshotUnloadError']
        );

        $this->dispatcher->$method(
            $this->eventNames->trackError(),
            [$this, 'onTrackError']
        );
    }

    public function onTaskRunError(TaskRunErrorEvent $event)
    {
        $msg = sprintf(
            '<error>%s</error>',
            $event->getException()->getMessage()
        );

        $this->output->writeln($msg);
    }

    public function onTaskEndError(TaskEndErrorEvent $event)
    {
        $msg = sprintf(
            '<error>%s</error>',
            $event->getException()->getMessage()
        );

        $this->output->writeln($msg);
    }

    public function onPackshotLoadError(PackshotErrorEvent $event)
    {
        $msg = sprintf(
            '<error>%s: "%s"</error>',
            $event->getPackshot()->getName(),
            $event->getException()->getMessage()
        );

        $this->output->writeln($msg);
    }

    public function onPackshotUnloadError(PackshotErrorEvent $event)
    {
        $msg = sprintf(
            '<error>%s: "%s"</error>',
            $event->getPackshot()->getName(),
            $event->getException()->getMessage()
        );

        $this->output->writeln($msg);
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        $msg = sprintf(
            '<error>%s: "%s"</error>',
            $event->getPackshot()->getName(),
            $event->getException()->getMessage()
        );

        $this->output->writeln($msg);
    }
}