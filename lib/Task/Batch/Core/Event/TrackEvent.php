<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Core\Event;

use Kompakt\Mediameister\Entity\TrackInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\Event;

class TrackEvent extends Event
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