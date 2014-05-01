<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot\Artwork\Loader\Factory;

use Kompakt\MediaDeliveryFramework\Entity\ReleaseInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Layout\LayoutInterface;

interface LoaderFactoryInterface
{
    public function getInstance(LayoutInterface $layout, ReleaseInterface $release);
}