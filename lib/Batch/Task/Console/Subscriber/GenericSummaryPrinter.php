<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Console\Subscriber;

use Kompakt\Mediameister\Generic\Console\Output\ConsoleOutputInterface;
use Kompakt\Mediameister\Batch\Task\EventNamesInterface;
use Kompakt\Mediameister\Batch\Task\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TaskEndEvent;
use Kompakt\Mediameister\Batch\Task\Subscriber\Share\Summary;
use Kompakt\Mediameister\Batch\Task\Subscriber\GenericSummaryMaker;
use Kompakt\Mediameister\Util\Counter;
use Kompakt\Mediameister\Util\Timer\Timer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GenericSummaryPrinter
{
    protected $dispatcher = null;
    protected $eventNames = null;
    protected $summary = null;
    protected $output = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames,
        Summary $summary,
        ConsoleOutputInterface $output
    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
        $this->summary = $summary;
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
            $this->eventNames->taskEnd(),
            [$this, 'onTaskEnd']
        );

        $this->dispatcher->$method(
            $this->eventNames->taskEndError(),
            [$this, 'onTaskEndError']
        );
    }

    public function onTaskEnd(TaskEndEvent $event)
    {
        $this->writeFullSummary($event->getTimer());
    }

    public function onTaskEndError(TaskEndErrorEvent $event)
    {
        $this->writeFullSummary($event->getTimer());
    }

    protected function writeFullSummary(Timer $timer)
    {
        $this->output->writeln(
            sprintf(
                '<comment>%s</comment>',
                $this->getSeparator()
            )
        );

        $this->writeItemSummary($this->summary->getPackshotCounter(), 'Packshots');
        $this->writeItemSummary($this->summary->getTrackCounter(), 'Tracks');

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
            = ($counter->count(GenericSummaryMaker::ERROR))
            ? sprintf(' <error>(%d errors)</error>', $counter->count(GenericSummaryMaker::ERROR))
            : ''
        ;

        $this->output->writeln(
            sprintf(
                '<info>= %s: %s total, %d ok</info>%s',
                $title,
                $counter->getTotal(),
                $counter->count(GenericSummaryMaker::OK),
                $error
            )
        );
    }

    protected function getSeparator()
    {
        return '---------------------------------------';
    }
}