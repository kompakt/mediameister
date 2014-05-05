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

class TrackErrorEvent implements EventInterface
{
    protected $track = null;
    protected $exception = null;

    public function __construct(TrackInterface $track, \Exception $exception)
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