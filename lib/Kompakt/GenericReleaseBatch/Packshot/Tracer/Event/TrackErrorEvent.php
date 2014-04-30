<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Tracer\Event;

use Kompakt\GenericReleaseBatch\Entity\TrackInterface;
use Symfony\Component\EventDispatcher\Event;

class TrackErrorEvent extends Event
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