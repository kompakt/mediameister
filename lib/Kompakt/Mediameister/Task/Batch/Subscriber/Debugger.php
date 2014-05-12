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
use Kompakt\Mediameister\Task\Batch\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\TaskRunEvent;
use Kompakt\Mediameister\Task\Batch\Event\TrackErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\TrackEvent;

class Debugger implements EventSubscriberInterface
{
    protected $eventNames = null;
    protected $output = null;

    public function __construct(
        EventNamesInterface $eventNames,
        ConsoleOutputInterface $output
    )
    {
        $this->eventNames = $eventNames;
        $this->output = $output;
    }

    public function getSubscriptions()
    {
        return array(
            // task events
            $this->eventNames->inputError() => array(
                array('onInputError', 0)
            ),
            $this->eventNames->taskRun() => array(
                array('onTaskRun', 0)
            ),
            $this->eventNames->taskRunError() => array(
                array('onTaskRunError', 0)
            ),
            $this->eventNames->taskEnd() => array(
                array('onTaskEnd', 0)
            ),
            $this->eventNames->taskEndError() => array(
                array('onTaskEndError', 0)
            ),
            // batch events
            $this->eventNames->batchStart() => array(
                array('onBatchStart', 0)
            ),
            $this->eventNames->batchStartError() => array(
                array('onBatchStartError', 0)
            ),
            $this->eventNames->packshotLoad() => array(
                array('onPackshotLoad', 0)
            ),
            $this->eventNames->packshotLoadError() => array(
                array('onPackshotLoadError', 0)
            ),
            $this->eventNames->batchEnd() => array(
                array('onBatchEnd', 0)
            ),
            $this->eventNames->batchEndError() => array(
                array('onBatchEndError', 0)
            ),
            // packshot events
            $this->eventNames->artwork() => array(
                array('onArtwork', 0)
            ),
            $this->eventNames->artworkError() => array(
                array('onArtworkError', 0)
            ),
            $this->eventNames->track() => array(
                array('onTrack', 0)
            ),
            $this->eventNames->trackError() => array(
                array('onTrackError', 0)
            ),
            $this->eventNames->metadata() => array(
                array('onMetadata', 0)
            ),
            $this->eventNames->metadataError() => array(
                array('onMetadataError', 0)
            )
        );
    }

    public function onInputError(InputErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<error>! Task input error: %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onTaskRun(TaskRunEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<info>+ Task run</info>'
            )
        );
    }

    public function onTaskRunError(TaskRunErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<error>+ Task run error %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onTaskEnd(TaskEndEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<info>+ Task end</info>'
            )
        );
    }

    public function onTaskEndError(TaskEndErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<error>+ Task end error %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onBatchStart(BatchStartEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <info>+ Batch start</info>'
            )
        );
    }

    public function onBatchStartError(BatchStartErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <error>! Batch start error: %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onBatchEnd(BatchEndEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <info>+ Batch end</info>'
            )
        );
    }

    public function onBatchEndError(BatchEndErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <error>! Batch end error: %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onPackshotLoad(PackshotLoadEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '    <info>+ Packshot load</info>'
            )
        );
    }

    public function onPackshotLoadError(PackshotLoadErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '    <error>! Packshot load error: %s: %s</error>',
                $event->getPackshot()->getName(),
                $event->getException()->getMessage()
            )
        );
    }

    public function onArtwork(ArtworkEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '      <info>+ Artwork</info>'
            )
        );
    }

    public function onArtworkError(ArtworkErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '      <error>! Artwork error: %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onTrack(TrackEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '        <info>+ Track</info>'
            )
        );
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '        <error>! Track error: %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onMetadata(MetadataEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '      <info>+ Metadata</info>'
            )
        );
    }

    public function onMetadataError(MetadataErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '      <error>! Metadata error: %s</error>',
                $event->getException()->getMessage()
            )
        );
    }
}