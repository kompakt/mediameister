<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch;

use Kompakt\MediaDeliveryFramework\Batch\Filter\PackshotFilterInterface;

interface BatchInterface
{
    public function getDir();
    public function getName();
    public function getPackshots(PackshotFilterInterface $filter = null);
    public function createPackshot($name);
}