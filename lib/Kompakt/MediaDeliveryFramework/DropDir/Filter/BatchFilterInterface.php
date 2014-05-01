<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\DropDir\Filter;

use Kompakt\MediaDeliveryFramework\Batch\BatchInterface;

interface BatchFilterInterface
{
    public function add(BatchInterface $batch);
    public function ignore(BatchInterface $batch);
}