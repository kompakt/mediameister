<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Tracer\Subscriber;

use Kompakt\Mediameister\Batch\Tracer\EventNamesInterface as BatchEventNamesInterface;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchEndErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchEndEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadEvent;
use Kompakt\Mediameister\Component\Native\Console\Output\ConsoleOutputInterface;
use Kompakt\Mediameister\Component\Native\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Packshot\Tracer\EventNamesInterface as PackshotEventNamesInterface;
use Kompakt\Mediameister\Packshot\Tracer\Event\ArtworkErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\ArtworkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\MetadataErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\MetadataEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackEvent;
use Kompakt\Mediameister\Task\Tracer\EventNamesInterface as TaskEventNamesInterface;
use Kompakt\Mediameister\Task\Tracer\Event\InputErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskEndEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskFinalEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskRunEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskRunErrorEvent;

class Debugger implements EventSubscriberInterface
{
    protected $taskEventNames = null;
    protected $batchEventNames = null;
    protected $packshotEventNames = null;
    protected $output = null;

    // processing state vars
    protected $sourceBatch = null;
    protected $targetDropDir = null;
    protected $currentPackshot = null;

    public function __construct(
        TaskEventNamesInterface $taskEventNames,
        BatchEventNamesInterface $batchEventNames,
        PackshotEventNamesInterface $packshotEventNames,
        ConsoleOutputInterface $output
    )
    {
        $this->taskEventNames = $taskEventNames;
        $this->batchEventNames = $batchEventNames;
        $this->packshotEventNames = $packshotEventNames;
        $this->output = $output;
    }

    public function getSubscriptions()
    {
        return array(
            // task event handlers
            $this->taskEventNames->inputError() => array(
                array('onInputError', 0)
            ),
            $this->taskEventNames->taskRun() => array(
                array('onTaskRun', 0)
            ),
            $this->taskEventNames->taskRunError() => array(
                array('onTaskRunError', 0)
            ),
            $this->taskEventNames->taskEnd() => array(
                array('onTaskEnd', 0)
            ),
            $this->taskEventNames->taskEndError() => array(
                array('onTaskEndError', 0)
            ),
            $this->taskEventNames->taskFinal() => array(
                array('onTaskFinal', 0)
            ),
            // batch event handlers
            $this->batchEventNames->batchStart() => array(
                array('onBatchStart', 0)
            ),
            $this->batchEventNames->batchStartError() => array(
                array('onBatchStartError', 0)
            ),
            $this->batchEventNames->packshotLoad() => array(
                array('onPackshotLoad', 0)
            ),
            $this->batchEventNames->packshotLoadError() => array(
                array('onPackshotLoadError', 0)
            ),
            $this->batchEventNames->batchEnd() => array(
                array('onBatchEnd', 0)
            ),
            $this->batchEventNames->batchEndError() => array(
                array('onBatchEndError', 0)
            ),
            // packshot event handlers
            $this->packshotEventNames->artwork() => array(
                array('onArtwork', 0)
            ),
            $this->packshotEventNames->artworkError() => array(
                array('onArtworkError', 0)
            ),
            $this->packshotEventNames->track() => array(
                array('onTrack', 0)
            ),
            $this->packshotEventNames->trackError() => array(
                array('onTrackError', 0)
            ),
            $this->packshotEventNames->metadata() => array(
                array('onMetadata', 0)
            ),
            $this->packshotEventNames->metadataError() => array(
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
        $this->sourceBatch = $event->getSourceBatch();
        $this->targetDropDir = $event->getTargetDropDir();

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

    public function onTaskFinal(TaskFinalEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<info>+ Task final</info>'
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
                '        <error>! Artwork error: %s</error>',
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