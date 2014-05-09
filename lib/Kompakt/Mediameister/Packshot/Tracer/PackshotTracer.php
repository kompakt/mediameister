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
use Kompakt\Mediameister\Packshot\Tracer\Event\ArtworkErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\ArtworkEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\MetadataErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\MetadataEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackErrorEvent;
use Kompakt\Mediameister\Packshot\Tracer\Event\TrackEvent;
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
                $this->eventNames->artwork(),
                new ArtworkEvent()
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->artworkError(),
                new ArtworkErrorEvent($e)
            );
        }

        foreach ($packshot->getRelease()->getTracks() as $track)
        {
            try {
                $this->dispatcher->dispatch(
                    $this->eventNames->track(),
                    new TrackEvent($track)
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
                $this->eventNames->metadata(),
                new MetadataEvent()
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->metadataError(),
                new MetadataErrorEvent($e)
            );
        }
    }
}