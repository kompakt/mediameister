<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\DropDir;

use Kompakt\MediaDeliveryFramework\DropDir\Filter\BatchFilterInterface;

interface DropDirInterface
{
    public function getBatches(BatchFilterInterface $filter = null);
    public function getBatch($name);
    public function createBatch($name);
}