<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Processor;

use Kompakt\ReleaseBatch\Packshot\PackshotInterface;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\Events;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\IntroErrorEvent;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\IntroEvent;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\IntroOkEvent;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\OutroErrorEvent;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\OutroEvent;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\OutroOkEvent;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\TrackErrorEvent;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\TrackEvent;
use Kompakt\ReleaseBatch\Packshot\Processor\Event\TrackOkEvent;
use Kompakt\ReleaseBatch\Packshot\Processor\PackshotProcessorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PackshotProcessor implements PackshotProcessorInterface
{
    protected $dispatcher = null;
    protected $packshot = null;

    public function __construct(EventDispatcherInterface $dispatcher, PackshotInterface $packshot)
    {
        $this->dispatcher = $dispatcher;
        $this->packshot = $packshot;
    }

    public function process()
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

        foreach ($this->packshot->getRelease()->getTracks() as $track)
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