<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Tracer;

use Kompakt\MediaDeliveryFramework\Batch\BatchInterface;
use Kompakt\MediaDeliveryFramework\Batch\Filter\PackshotFilterInterface;

interface BatchTracerInterface
{
    public function trace(BatchInterface $batch, PackshotFilterInterface $filter = null);
}