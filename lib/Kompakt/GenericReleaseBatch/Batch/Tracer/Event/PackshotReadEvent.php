<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Tracer\Event;

use Kompakt\GenericReleaseBatch\Packshot\PackshotInterface;
use Symfony\Component\EventDispatcher\Event;

class PackshotReadEvent extends Event
{
    protected $packshot = null;

    public function __construct(PackshotInterface $packshot)
    {
        $this->packshot = $packshot;
    }

    public function getPackshot()
    {
        return $this->packshot;
    }
}