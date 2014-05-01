<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Tracer\Factory;

use Kompakt\MediaDeliveryFramework\Batch\BatchInterface;

interface BatchTracerFactoryInterface
{
    public function getInstance();
}