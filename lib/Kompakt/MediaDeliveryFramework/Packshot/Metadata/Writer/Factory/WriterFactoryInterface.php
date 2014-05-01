<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot\Metadata\Writer\Factory;

use Kompakt\MediaDeliveryFramework\Entity\ReleaseInterface;

interface WriterFactoryInterface
{
    public function getInstance(ReleaseInterface $release);
}