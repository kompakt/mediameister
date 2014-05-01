<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Tracer\Event;

use Kompakt\MediaDeliveryFramework\Packshot\PackshotInterface;
use Symfony\Component\EventDispatcher\Event;

class PackshotReadOkEvent extends Event
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