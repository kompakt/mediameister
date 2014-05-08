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
use Kompakt\Mediameister\Packshot\Tracer\Event\IntroErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\IntroEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\IntroOkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\OutroErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\OutroEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\OutroOkEvent;
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
                $this->eventNames->intro(),
                new IntroEvent()
            );

            $this->dispatcher->dispatch(
                $this->eventNames->introOk(),
                new IntroOkEvent()
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->introError(),
                new IntroErrorEvent($e)
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
                $this->eventNames->outro(),
                new OutroEvent()
            );

            $this->dispatcher->dispatch(
                $this->eventNames->outroOk(),
                new OutroOkEvent()
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->outroError(),
                new OutroErrorEvent($e)
            );
        }
    }
}