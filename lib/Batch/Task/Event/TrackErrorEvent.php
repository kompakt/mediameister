<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Event;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Entity\TrackInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\Event;
use Kompakt\Mediameister\Packshot\PackshotInterface;

class TrackErrorEvent extends Event
{
    protected $exception = null;
    protected $batch = null;
    protected $packshot = null;
    protected $track = null;

    public function __construct(\Exception $exception, BatchInterface $batch, PackshotInterface $packshot, TrackInterface $track)
    {
        $this->exception = $exception;
        $this->batch = $batch;
        $this->packshot = $packshot;
        $this->track = $track;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function getBatch()
    {
        return $this->batch;
    }

    public function getPackshot()
    {
        return $this->packshot;
    }

    public function getTrack()
    {
        return $this->track;
    }
}