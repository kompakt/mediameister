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
#use Kompakt\Mediameister\Batch\Tracer\Event\BatchEndOkEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartEvent;
#use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartOkEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadEvent;
#use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadOkEvent;
use Kompakt\Mediameister\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Packshot\Tracer\EventNamesInterface as PackshotEventNamesInterface;
use Kompakt\Mediameister\Packshot\Tracer\Event\ArtworkErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\ArtworkEvent;
#use Kompakt\Mediameister\Packshot\Tracer\Event\ArtworkOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\MetadataErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\MetadataEvent;
#use Kompakt\Mediameister\Packshot\Tracer\Event\MetadataOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackEvent;
#use Kompakt\Mediameister\Packshot\Tracer\Event\TrackOkEvent;
use Kompakt\Mediameister\Task\Tracer\EventNamesInterface as TaskEventNamesInterface;
use Kompakt\Mediameister\Task\Tracer\Event\InputErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskEndEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskEndErrorEvent;
#use Kompakt\Mediameister\Task\Tracer\Event\TaskEndOkEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskFinalEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskRunEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskRunErrorEvent;
#use Kompakt\Mediameister\Task\Tracer\Event\TaskRunOkEvent;

class Debugger implements EventSubscriberInterface
{
    protected $taskEventNames = null;
    protected $batchEventNames = null;
    protected $packshotEventNames = null;

    // processing state vars
    protected $sourceBatch = null;
    protected $targetDropDir = null;
    protected $currentPackshot = null;

    public function __construct(
        TaskEventNamesInterface $taskEventNames,
        BatchEventNamesInterface $batchEventNames,
        PackshotEventNamesInterface $packshotEventNames
    )
    {
        $this->taskEventNames = $taskEventNames;
        $this->batchEventNames = $batchEventNames;
        $this->packshotEventNames = $packshotEventNames;
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
            /*$this->taskEventNames->taskRunOk() => array(
                array('onTaskRunOk', 0)
            ),*/
            $this->taskEventNames->taskRunError() => array(
                array('onTaskRunError', 0)
            ),
            $this->taskEventNames->taskEnd() => array(
                array('onTaskEnd', 0)
            ),
            /*$this->taskEventNames->taskEndOk() => array(
                array('onTaskEndOk', 0)
            ),*/
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
            /*$this->batchEventNames->batchStartOk() => array(
                array('onBatchStartOk', 0)
            ),*/
            $this->batchEventNames->batchStartError() => array(
                array('onBatchStartError', 0)
            ),
            $this->batchEventNames->packshotLoad() => array(
                array('onPackshotLoad', 0)
            ),
            /*$this->batchEventNames->packshotLoadOk() => array(
                array('onPackshotLoadOk', 0)
            ),*/
            $this->batchEventNames->packshotLoadError() => array(
                array('onPackshotLoadError', 0)
            ),
            $this->batchEventNames->batchEnd() => array(
                array('onBatchEnd', 0)
            ),
            /*$this->batchEventNames->batchEndOk() => array(
                array('onBatchEndOk', 0)
            ),*/
            $this->batchEventNames->batchEndError() => array(
                array('onBatchEndError', 0)
            ),
            // packshot event handlers
            $this->packshotEventNames->artwork() => array(
                array('onArtwork', 0)
            ),
            /*$this->packshotEventNames->artworkOk() => array(
                array('onArtworkOk', 0)
            ),*/
            $this->packshotEventNames->artworkError() => array(
                array('onArtworkError', 0)
            ),
            $this->packshotEventNames->track() => array(
                array('onTrack', 0)
            ),
            /*$this->packshotEventNames->trackOk() => array(
                array('onTrackOk', 0)
            ),*/
            $this->packshotEventNames->trackError() => array(
                array('onTrackError', 0)
            ),
            $this->packshotEventNames->metadata() => array(
                array('onMetadata', 0)
            ),
            /*$this->packshotEventNames->metadataOk() => array(
                array('onMetadataOk', 0)
            ),*/
            $this->packshotEventNames->metadataError() => array(
                array('onMetadataError', 0)
            )
        );
    }

    public function onInputError(InputErrorEvent $event)
    {#throw new \Exception('onInputError');
        echo sprintf("! Task input error: (!) %s\n", $event->getException()->getMessage());
    }

    public function onTaskRun(TaskRunEvent $event)
    {#throw new \Exception('onTaskRun');
        echo sprintf("> Task run\n");
        $this->sourceBatch = $event->getSourceBatch();
        $this->targetDropDir = $event->getTargetDropDir();
    }

    /*public function onTaskRunOk(TaskRunOkEvent $event)
    {throw new \Exception('onTaskRunOk');
        echo sprintf("> Task run ok\n");
    }*/

    public function onTaskRunError(TaskRunErrorEvent $event)
    {#throw new \Exception('onTaskRunError');
        echo sprintf("> Task run error %s\n", $event->getException()->getMessage());
    }

    public function onTaskEnd(TaskEndEvent $event)
    {#throw new \Exception('onTaskEnd');
        echo sprintf("> Task end\n");
    }

    /*public function onTaskEndOk(TaskEndOkEvent $event)
    {#throw new \Exception('onTaskEndOk');
        echo sprintf("> Task end ok\n");
    }*/

    public function onTaskEndError(TaskEndErrorEvent $event)
    {#throw new \Exception('onTaskEndError');
        echo sprintf("> Task end error %s\n", $event->getException()->getMessage());
    }

    public function onTaskFinal(TaskFinalEvent $event)
    {#throw new \Exception('onTaskFinal');
        echo sprintf("> Task final\n");
    }

    public function onBatchStart(BatchStartEvent $event)
    {#throw new \Exception('onBatchStart');
        echo sprintf("  > Batch start\n");
    }

    /*public function onBatchStartOk(BatchStartOkEvent $event)
    {#throw new \Exception('onBatchStartOk');
        echo sprintf("  > Batch start ok\n");
    }*/

    public function onBatchStartError(BatchStartErrorEvent $event)
    {#throw new \Exception('onBatchStartError');
        echo sprintf("  ! Batch start error: '%s'\n", $event->getException()->getMessage());
    }

    public function onBatchEnd(BatchEndEvent $event)
    {#throw new \Exception('onBatchEnd');
        echo sprintf("  > Batch end\n");
    }

    /*public function onBatchEndOk(BatchEndOkEvent $event)
    {#throw new \Exception('onBatchEndOk');
        echo sprintf("  > Batch end ok\n");
    }*/

    public function onBatchEndError(BatchEndErrorEvent $event)
    {#throw new \Exception('onBatchEndError');
        echo sprintf("  ! Batch end error: '%s'\n", $event->getException()->getMessage());
    }

    public function onPackshotLoad(PackshotLoadEvent $event)
    {#throw new \Exception('onPackshotLoad');
        echo sprintf("    > Packshot load\n");
    }

    /*public function onPackshotLoadOk(PackshotLoadOkEvent $event)
    {#throw new \Exception('onPackshotLoadOk');
        $this->currentPackshot = $event->getPackshot();
        echo sprintf("    > Packshot load ok '%s' // %s\n", $this->currentPackshot->getName(), $this->currentPackshot->getRelease()->getName());
    }*/

    public function onPackshotLoadError(PackshotLoadErrorEvent $event)
    {#throw new \Exception('onPackshotLoadError');
        echo sprintf("    ! Packshot load error '%s': (!) %s\n", $event->getPackshot()->getName(), $event->getException()->getMessage());
    }

    public function onArtwork(ArtworkEvent $event)
    {#throw new \Exception('onArtwork');
        echo sprintf("      > Artwork\n");
    }

    /*public function onArtworkOk(ArtworkOkEvent $event)
    {
        echo sprintf("      > Artwork ok\n");
    }*/

    public function onArtworkError(ArtworkErrorEvent $event)
    {#throw new \Exception('onArtworkError');
        echo sprintf("        ! Artwork error: '%s'\n", $event->getException()->getMessage());
    }

    public function onTrack(TrackEvent $event)
    {#throw new \Exception('onTrack');
        echo sprintf("        > Track\n");
    }

    /*public function onTrackOk(TrackOkEvent $event)
    {
        echo sprintf("        > Track ok\n");
    }*/

    public function onTrackError(TrackErrorEvent $event)
    {#throw new \Exception('onTrackError');
        echo sprintf("        ! Track error: '%s'\n", $event->getException()->getMessage());
    }

    public function onMetadata(MetadataEvent $event)
    {#throw new \Exception('onMetadata');
        echo sprintf("      > Metadata\n");
    }

    /*public function onMetadataOk(MetadataOkEvent $event)
    {
        echo sprintf("      > Metadata ok\n");
    }*/

    public function onMetadataError(MetadataErrorEvent $event)
    {#throw new \Exception('onMetadataError');
        echo sprintf("      ! Metadata error: '%s'\n", $event->getException()->getMessage());
    }
}