<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Event;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;
use Symfony\Component\EventDispatcher\Event;

class PackshotEvent extends Event
{
    protected $batch = null;
    protected $packshot = null;

    public function __construct(BatchInterface $batch, PackshotInterface $packshot)
    {
        $this->batch = $batch;
        $this->packshot = $packshot;
    }

    public function getBatch()
    {
        return $this->batch;
    }

    public function getPackshot()
    {
        return $this->packshot;
    }
}