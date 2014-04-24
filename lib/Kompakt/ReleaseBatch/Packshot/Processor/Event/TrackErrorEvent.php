<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Processor\Event;

use Kompakt\ReleaseBatch\Entity\Track;
use Symfony\Component\EventDispatcher\Event;

class TrackErrorEvent extends Event
{
    protected $track = null;
    protected $exception = null;

    public function __construct(Track $track, \Exception $exception)
    {
        $this->track = $track;
        $this->exception = $exception;
    }

    public function getTrack()
    {
        return $this->track;
    }

    public function getException()
    {
        return $this->exception;
    }
}