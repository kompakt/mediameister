<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Filter;

use Kompakt\MediaDeliveryFramework\Packshot\PackshotInterface;

interface PackshotFilterInterface
{
    public function add(PackshotInterface $packshot);
    public function ignore(PackshotInterface $packshot);
}