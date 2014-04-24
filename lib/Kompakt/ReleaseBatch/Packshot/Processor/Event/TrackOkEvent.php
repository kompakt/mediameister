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

class TrackOkEvent extends Event
{
    protected $track = null;

    public function __construct(Track $track)
    {
        $this->track = $track;
    }

    public function getTrack()
    {
        return $this->track;
    }
}