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
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotReadErrorEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotReadEvent;
use Kompakt\Mediameister\Batch\Tracer\Event\PackshotReadOkEvent;
use Kompakt\Mediameister\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Packshot\Tracer\EventNamesInterface as PackshotEventNamesInterface;
use Kompakt\Mediameister\Packshot\Tracer\Event\IntroErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\IntroEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\IntroOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\OutroErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\OutroEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\OutroOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackOkEvent;
use Kompakt\Mediameister\Task\Tracer\EventNamesInterface as TaskEventNamesInterface;
use Kompakt\Mediameister\Task\Tracer\Event\InputErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\InputOkEvent;

class Debugger implements EventSubscriberInterface
{
    protected $taskEventNames = null;
    protected $batchEventNames = null;
    protected $packshotEventNames = null;

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
            $this->taskEventNames->inputOk() => array(
                array('onInputOk', 0)
            ),
            $this->taskEventNames->inputError() => array(
                array('onInputError', 0)
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
            $this->batchEventNames->packshotRead() => array(
                array('onPackshotRead', 0)
            ),
            $this->batchEventNames->packshotReadOk() => array(
                array('onPackshotReadOk', 0)
            ),
            $this->batchEventNames->packshotReadError() => array(
                array('onPackshotReadError', 0)
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
            $this->packshotEventNames->intro() => array(
                array('onPackshotIntro', 0)
            ),
            $this->packshotEventNames->introOk() => array(
                array('onPackshotIntroOk', 0)
            ),
            $this->packshotEventNames->introError() => array(
                array('onPackshotIntroError', 0)
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
            $this->packshotEventNames->outro() => array(
                array('onPackshotOutro', 0)
            ),
            $this->packshotEventNames->outroOk() => array(
                array('onPackshotOutroOk', 0)
            ),
            $this->packshotEventNames->outroError() => array(
                array('onPackshotOutroError', 0)
            )
        );
    }

    public function onInputOk(InputOkEvent $event)
    {
        echo sprintf("Input ok (Batch: %s)\n", $event->getSourceBatch()->getName());
    }

    public function onInputError(InputErrorEvent $event)
    {
        echo sprintf("! Task input error: (!) %s\n", $event->getException()->getMessage());
    }

    public function onBatchStart(BatchStartEvent $event)
    {
        echo sprintf("Batch start\n");
    }

    public function onBatchStartOk(BatchStartOkEvent $event)
    {
        echo sprintf("Batch start ok\n");
    }

    public function onBatchStartError(BatchStartErrorEvent $event)
    {
        echo sprintf("Batch start error\n");
    }

    public function onBatchEnd(BatchEndEvent $event)
    {
        echo sprintf("Batch end\n");
    }

    public function onBatchEndOk(BatchEndOkEvent $event)
    {
        echo sprintf("Batch end ok\n");
    }

    public function onBatchEndError(BatchEndErrorEvent $event)
    {
        echo sprintf("Batch end error\n");
    }

    protected $currentPackshot = null;

    public function onPackshotRead(PackshotReadEvent $event)
    {
        #echo sprintf("Packshot read\n");
    }

    public function onPackshotReadOk(PackshotReadOkEvent $event)
    {
        $this->currentPackshot = $event->getPackshot();
        echo sprintf("> %s // %s\n", $this->currentPackshot->getName(), $this->currentPackshot->getRelease()->getName());
        #echo sprintf("Packshot read ok\n");
    }

    public function onPackshotReadError(PackshotReadErrorEvent $event)
    {
        echo sprintf("! %s: (!) %s\n", $event->getPackshot()->getName(), $event->getException()->getMessage());
        $this->currentPackshot = null;
    }

    public function onPackshotIntro(IntroEvent $event)
    {
        if (!$this->currentPackshot)
        {
            #return;
        }

        #echo sprintf("Packshot intro\n");
    }

    public function onPackshotIntroOk(IntroOkEvent $event)
    {
        if (!$this->currentPackshot)
        {
            #return;
        }

        #echo sprintf("Packshot intro ok\n");
    }

    public function onPackshotIntroError(IntroErrorEvent $event)
    {
        if (!$this->currentPackshot)
        {
            #return;
        }

        echo sprintf("! Packshot intro error: (!) %s\n", $event->getException()->getMessage());
    }

    public function onTrack(TrackEvent $event)
    {
        if (!$this->currentPackshot)
        {
            #return;
        }

        #echo sprintf("Track\n");
    }

    public function onTrackOk(TrackOkEvent $event)
    {
        if (!$this->currentPackshot)
        {
            #return;
        }

        echo sprintf("  > Track ok\n");
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        if (!$this->currentPackshot)
        {
            #return;
        }

        echo sprintf("  ! Track error: (!) %s\n", $event->getException()->getMessage());
    }

    public function onPackshotOutro(OutroEvent $event)
    {
        if (!$this->currentPackshot)
        {
            #return;
        }

        #echo sprintf("Packshot outro\n");
    }

    public function onPackshotOutroOk(OutroOkEvent $event)
    {
        if (!$this->currentPackshot)
        {
            #return;
        }

        #echo sprintf("Packshot outro ok\n");
    }

    public function onPackshotOutroError(OutroErrorEvent $event)
    {
        if (!$this->currentPackshot)
        {
            #return;
        }

        echo sprintf("! Packshot outro error: (!) %s\n", $event->getException()->getMessage());
    }
}