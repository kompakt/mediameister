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
use Kompakt\Mediameister\Batch\Task\Event\TrackErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TrackEvent;
use Kompakt\Mediameister\Util\Counter;
use Kompakt\Mediameister\Util\Timer\Timer;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SummaryPrinter
{
    const OK = 'ok';
    const ERROR = 'error';

    protected $dispatcher = null;
    protected $eventNames = null;
    protected $output = null;
    protected $packshotCounter = null;
    protected $trackCounter = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames,
        ConsoleOutputInterface $output,
        Counter $counterPrototype
    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
        $this->output = $output;
        $this->packshotCounter = clone $counterPrototype;
        $this->trackCounter = clone $counterPrototype;
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
            $this->eventNames->taskEnd(),
            [$this, 'onTaskEnd']
        );

        $this->dispatcher->$method(
            $this->eventNames->taskEndError(),
            [$this, 'onTaskEndError']
        );

        $this->dispatcher->$method(
            $this->eventNames->packshotLoadOk(),
            [$this, 'onPackshotLoad']
        );

        $this->dispatcher->$method(
            $this->eventNames->packshotLoadError(),
            [$this, 'onPackshotLoadError']
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

    public function onTaskEnd(TaskEndEvent $event)
    {
        $this->printSummary($event->getTimer());
    }

    public function onTaskEndError(TaskEndErrorEvent $event)
    {
        $this->printSummary($event->getTimer());
    }

    public function onPackshotLoad(PackshotEvent $event)
    {
        $id = $event->getPackshot()->getName();
        $this->packshotCounter->add(self::OK, $id);
    }

    public function onPackshotLoadError(PackshotErrorEvent $event)
    {
        $id = $event->getPackshot()->getName();
        $this->packshotCounter->add(self::ERROR, $id);
    }

    public function onTrack(TrackEvent $event)
    {
        $id = $event->getPackshot()->getName() . spl_object_hash($event->getTrack());
        $this->trackCounter->add(self::OK, $id);
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        $id = $event->getPackshot()->getName() . spl_object_hash($event->getTrack());
        $this->trackCounter->add(self::ERROR, $id);
    }

    protected function printSummary(Timer $timer)
    {
        $this->output->writeln(
            sprintf(
                '<comment>%s</comment>',
                $this->getSeparator()
            )
        );

        $this->writeItemSummary($this->packshotCounter, 'Packshots');
        $this->writeItemSummary($this->trackCounter, 'Tracks');

        $this->output->writeln(
            sprintf(
                '<info>= Time: %d seconds</info>',
                $timer->getSeconds()
            )
        );
    }

    protected function writeItemSummary(Counter $counter, $title)
    {
        $error
            = ($counter->count(self::ERROR))
            ? sprintf(' <error>(%d errors)</error>', $counter->count(self::ERROR))
            : ''
        ;

        $this->output->writeln(
            sprintf(
                '<info>= %s: %s total, %d ok</info>%s',
                $title,
                $counter->getTotal(),
                $counter->count(self::OK),
                $error
            )
        );
    }

    protected function getSeparator()
    {
        return '---------------------------------------';
    }
}