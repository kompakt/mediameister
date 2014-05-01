<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot\Tracer;

use Kompakt\MediaDeliveryFramework\Packshot\PackshotInterface;

interface PackshotTracerInterface
{
    public function trace(PackshotInterface $packshot);
}