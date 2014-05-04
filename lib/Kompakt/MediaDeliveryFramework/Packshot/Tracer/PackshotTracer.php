<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot\Tracer;

use Kompakt\MediaDeliveryFramework\Packshot\PackshotInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\Events;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\IntroErrorEvent;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\IntroEvent;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\IntroOkEvent;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\OutroErrorEvent;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\OutroEvent;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\OutroOkEvent;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\TrackErrorEvent;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\TrackEvent;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event\TrackOkEvent;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\PackshotTracerInterface;
use Kompakt\MediaDeliveryFramework\EventDispatcher\EventDispatcherInterface;

class PackshotTracer implements PackshotTracerInterface
{
    protected $dispatcher = null;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function trace(PackshotInterface $packshot)
    {
        try {
            $event = new IntroEvent();
            $this->dispatcher->dispatch(Events::INTRO, $event);
            $event = new IntroOkEvent();
            $this->dispatcher->dispatch(Events::INTRO_OK, $event);
        }
        catch (\Exception $e)
        {
            $event = new IntroErrorEvent($e);
            $this->dispatcher->dispatch(Events::INTRO_ERROR, $event);
        }

        foreach ($packshot->getRelease()->getTracks() as $track)
        {
            try {
                $event = new TrackEvent($track);
                $this->dispatcher->dispatch(Events::TRACK, $event);
                $event = new TrackOkEvent($track);
                $this->dispatcher->dispatch(Events::TRACK_OK, $event);
            }
            catch (\Exception $e)
            {
                $event = new TrackErrorEvent($track, $e);
                $this->dispatcher->dispatch(Events::TRACK_ERROR, $event);
            }
        }

        try {
            $event = new OutroEvent();
            $this->dispatcher->dispatch(Events::OUTRO, $event);
            $event = new OutroOkEvent();
            $this->dispatcher->dispatch(Events::OUTRO_OK, $event);
        }
        catch (\Exception $e)
        {
            $event = new OutroErrorEvent($e);
            $this->dispatcher->dispatch(Events::OUTRO_ERROR, $event);
        }
    }
}