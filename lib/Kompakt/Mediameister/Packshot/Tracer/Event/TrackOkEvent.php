<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Tracer\Event;

use Kompakt\Mediameister\Entity\TrackInterface;
use Kompakt\Mediameister\EventDispatcher\EventInterface;

class TrackOkEvent implements EventInterface
{
    protected $track = null;

    public function __construct(TrackInterface $track)
    {
        $this->track = $track;
    }

    public function getTrack()
    {
        return $this->track;
    }
}