<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Tracer;

use Kompakt\Mediameister\Packshot\PackshotInterface;
use Kompakt\Mediameister\Packshot\Tracer\EventNamesInterface;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotStartErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotStartEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotStartOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotEndErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotEndEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\PackshotEndOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\PackshotTracerInterface;
use Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface;

class PackshotTracer implements PackshotTracerInterface
{
    protected $dispatcher = null;
    protected $eventNames = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames
    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
    }

    public function trace(PackshotInterface $packshot)
    {
        try {
            $this->dispatcher->dispatch(
                $this->eventNames->packshotStart(),
                new PackshotStartEvent()
            );

            $this->dispatcher->dispatch(
                $this->eventNames->packshotStartOk(),
                new PackshotStartOkEvent()
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->packshotStartError(),
                new PackshotStartErrorEvent($e)
            );
        }

        foreach ($packshot->getRelease()->getTracks() as $track)
        {
            try {
                $this->dispatcher->dispatch(
                    $this->eventNames->track(),
                    new TrackEvent($track)
                );

                $this->dispatcher->dispatch(
                    $this->eventNames->trackOk(),
                    new TrackOkEvent($track)
                );
            }
            catch (\Exception $e)
            {
                $this->dispatcher->dispatch(
                    $this->eventNames->trackError(),
                    new TrackErrorEvent($track, $e)
                );
            }
        }

        try {
            $this->dispatcher->dispatch(
                $this->eventNames->packshotEnd(),
                new PackshotEndEvent()
            );

            $this->dispatcher->dispatch(
                $this->eventNames->packshotEndOk(),
                new PackshotEndOkEvent()
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->packshotEndError(),
                new PackshotEndErrorEvent($e)
            );
        }
    }
}