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
use Kompakt\Mediameister\Batch\Tracer\Event\BatchEndOkEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\BatchStartOkEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotLoadOkEvent;
use Kompakt\Mediameister\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Packshot\Tracer\EventNamesInterface as PackshotEventNamesInterface;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotStartErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotStartEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotStartOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotEndErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotEndEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotEndOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackOkEvent;
use Kompakt\Mediameister\Task\Tracer\EventNamesInterface as TaskEventNamesInterface;
use Kompakt\Mediameister\Task\Tracer\Event\InputErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskEndEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskFinalEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskStartEvent;

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
            
            $this->taskEventNames->inputError() => array(
                array('onInputError', 0)
            ),
            $this->taskEventNames->taskStart() => array(
                array('onTaskStart', 0)
            ),
            $this->taskEventNames->taskEnd() => array(
                array('onTaskEnd', 0)
            ),
            $this->taskEventNames->taskFinal() => array(
                array('onTaskFinal', 0)
            ),
            $this->taskEventNames->taskError() => array(
                array('onTaskError', 0)
            ),


            $this->batchEventNames->batchStart() => array(
                array('onBatchStart', 0)
            ),
            $this->batchEventNames->batchStartOk() => array(
                array('onBatchStartOk', 0)
            ),
            $this->batchEventNames->batchStartError() => array(
                array('onBatchStartError', 0)
            ),
            $this->batchEventNames->packshotLoad() => array(
                array('onPackshotLoad', 0)
            ),
            $this->batchEventNames->packshotLoadOk() => array(
                array('onPackshotLoadOk', 0)
            ),
            $this->batchEventNames->packshotLoadError() => array(
                array('onPackshotLoadError', 0)
            ),
            $this->batchEventNames->batchEnd() => array(
                array('onBatchEnd', 0)
            ),
            $this->batchEventNames->batchEndOk() => array(
                array('onBatchEndOk', 0)
            ),
            $this->batchEventNames->batchEndError() => array(
                array('onBatchEndError', 0)
            ),


            $this->packshotEventNames->packshotStart() => array(
                array('onPackshotStart', 0)
            ),
            $this->packshotEventNames->packshotStartOk() => array(
                array('onPackshotStartOk', 0)
            ),
            $this->packshotEventNames->packshotStartError() => array(
                array('onPackshotStartError', 0)
            ),
            $this->packshotEventNames->track() => array(
                array('onTrack', 0)
            ),
            $this->packshotEventNames->trackOk() => array(
                array('onTrackOk', 0)
            ),
            $this->packshotEventNames->trackError() => array(
                array('onTrackError', 0)
            ),
            $this->packshotEventNames->packshotEnd() => array(
                array('onPackshotEnd', 0)
            ),
            $this->packshotEventNames->packshotEndOk() => array(
                array('onPackshotEndOk', 0)
            ),
            $this->packshotEventNames->packshotEndError() => array(
                array('onPackshotEndError', 0)
            )
        );
    }

    public function onInputError(InputErrorEvent $event)
    {#throw new \Exception('onInputError');
        echo sprintf("! Task input error: (!) %s\n", $event->getException()->getMessage());
    }

    public function onTaskStart(TaskStartEvent $event)
    {#throw new \Exception('onTaskStart');
        $this->sourceBatch = $event->getSourceBatch();
        $this->targetDropDir = $event->getTargetDropDir();
        echo sprintf("> Task run\n");
    }

    public function onTaskEnd(TaskEndEvent $event)
    {#throw new \Exception('onTaskEnd');
        echo sprintf("> Task end\n");
    }

    public function onTaskFinal(TaskFinalEvent $event)
    {#throw new \Exception('onTaskFinal');
        echo sprintf("> Task final\n");
    }

    public function onTaskError(TaskErrorEvent $event)
    {#throw new \Exception('onTaskError');
        echo sprintf("! Task error: (!) %s\n", $event->getException()->getMessage());
    }

    public function onBatchStart(BatchStartEvent $event)
    {#throw new \Exception('onBatchStart');
        echo sprintf("> Batch start: '%s'\n", $this->sourceBatch->getName());
    }

    public function onBatchStartOk(BatchStartOkEvent $event)
    {#throw new \Exception('onBatchStartOk');
        echo sprintf("> Batch start ok\n");
    }

    public function onBatchStartError(BatchStartErrorEvent $event)
    {#throw new \Exception('onBatchStartError');
        echo sprintf("! Batch start error: '%s'\n", $event->getException()->getMessage());
    }

    public function onBatchEnd(BatchEndEvent $event)
    {#throw new \Exception('onBatchEnd');
        echo sprintf("> Batch end: '%s'\n", $this->sourceBatch->getName());
    }

    public function onBatchEndOk(BatchEndOkEvent $event)
    {#throw new \Exception('onBatchEndOk');
        echo sprintf("> Batch end ok\n");
    }

    public function onBatchEndError(BatchEndErrorEvent $event)
    {#throw new \Exception('onBatchEndError');
        echo sprintf("! Batch end error: '%s'\n", $event->getException()->getMessage());
    }

    public function onPackshotLoad(PackshotLoadEvent $event)
    {#throw new \Exception('onPackshotLoad');
        echo sprintf("Packshot load\n");
    }

    public function onPackshotLoadOk(PackshotLoadOkEvent $event)
    {
        #throw new \Exception('onPackshotLoadOk');
        $this->currentPackshot = $event->getPackshot();
        echo sprintf("> %s // %s\n", $this->currentPackshot->getName(), $this->currentPackshot->getRelease()->getName());
        #echo sprintf("Packshot load ok\n");
    }

    public function onPackshotLoadError(PackshotLoadErrorEvent $event)
    {
        #throw new \Exception('onPackshotLoadError');
        echo sprintf("! Packshot load error '%s': (!) %s\n", $event->getPackshot()->getName(), $event->getException()->getMessage());
    }

    public function onPackshotStart(PackshotStartEvent $event)
    {
        echo sprintf("Packshot packshotStart\n");
    }

    public function onPackshotStartOk(PackshotStartOkEvent $event)
    {
        echo sprintf("Packshot packshotStart ok\n");
    }

    public function onPackshotStartError(PackshotStartErrorEvent $event)
    {
        echo sprintf("! Packshot packshotStart error: (!) %s\n", $event->getException()->getMessage());
    }

    public function onTrack(TrackEvent $event)
    {
        echo sprintf("Track\n");
    }

    public function onTrackOk(TrackOkEvent $event)
    {
        echo sprintf("  > Track ok\n");
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        echo sprintf("  ! Track error: (!) %s\n", $event->getException()->getMessage());
    }

    public function onPackshotEnd(PackshotEndEvent $event)
    {
        echo sprintf("Packshot packshotEnd\n");
    }

    public function onPackshotEndOk(PackshotEndOkEvent $event)
    {
        echo sprintf("Packshot packshotEnd ok\n");
    }

    public function onPackshotEndError(PackshotEndErrorEvent $event)
    {
        echo sprintf("! Packshot packshotEnd error: (!) %s\n", $event->getException()->getMessage());
    }
}