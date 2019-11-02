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
use Kompakt\Mediameister\Packshot\PackshotInterface;
use Symfony\Contracts\EventDispatcher\Event;

class TrackEvent extends Event
{
    protected $batch = null;
    protected $packshot = null;
    protected $track = null;

    public function __construct(BatchInterface $batch, PackshotInterface $packshot, TrackInterface $track)
    {
        $this->batch = $batch;
        $this->packshot = $packshot;
        $this->track = $track;
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