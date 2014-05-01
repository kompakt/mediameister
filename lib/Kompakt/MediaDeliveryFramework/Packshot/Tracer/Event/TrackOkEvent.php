<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot\Tracer\Event;

use Kompakt\MediaDeliveryFramework\Entity\TrackInterface;
use Symfony\Component\EventDispatcher\Event;

class TrackOkEvent extends Event
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