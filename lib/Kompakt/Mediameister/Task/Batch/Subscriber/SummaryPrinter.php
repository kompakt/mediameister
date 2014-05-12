<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Subscriber;

use Kompakt\Mediameister\Generic\Console\Output\ConsoleOutputInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Task\Batch\EventNamesInterface;
use Kompakt\Mediameister\Task\Batch\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\TaskEndEvent;
use Kompakt\Mediameister\Task\Batch\Subscriber\Bridge\Summary;

class SummaryPrinter implements EventSubscriberInterface
{
    protected $eventNames = null;
    protected $summary = null;
    protected $output = null;

    public function __construct(
        EventNamesInterface $eventNames,
        Summary $summary,
        ConsoleOutputInterface $output
    )
    {
        $this->eventNames = $eventNames;
        $this->summary = $summary;
        $this->output = $output;
    }

    public function getSubscriptions()
    {
        return array(
            // task events
            $this->eventNames->taskEnd() => array(
                array('onTaskEnd', 0)
            ),
            $this->eventNames->taskEndError() => array(
                array('onTaskEndError', 0)
            )
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

    public function printSummary($timer)
    {
        $this->output->writeln(
            sprintf(
                '<info>= Packshots: %s total, %d ok (%d errors)</info>',
                $this->summary->getPackshotCounter()->getTotal(),
                $this->summary->getPackshotCounter()->getOks(),
                $this->summary->getPackshotCounter()->getErrors()
            )
        );

        $this->output->writeln(
            sprintf(
                '<info>= Artwork: %s total, %d ok (%d errors)</info>',
                $this->summary->getArtworkCounter()->getTotal(),
                $this->summary->getArtworkCounter()->getOks(),
                $this->summary->getArtworkCounter()->getErrors()
            )
        );

        $this->output->writeln(
            sprintf(
                '<info>= Tracks: %s total, %d ok (%d errors)</info>',
                $this->summary->getTrackCounter()->getTotal(),
                $this->summary->getTrackCounter()->getOks(),
                $this->summary->getTrackCounter()->getErrors()
            )
        );

        $this->output->writeln(
            sprintf(
                '<info>= Metadata: %s total, %d ok (%d errors)</info>',
                $this->summary->getMetadataCounter()->getTotal(),
                $this->summary->getMetadataCounter()->getOks(),
                $this->summary->getMetadataCounter()->getErrors()
            )
        );

        $this->output->writeln(
            sprintf(
                '<info>= Time: %d seconds</info>',
                $timer->getSeconds()
            )
        );
    }
}