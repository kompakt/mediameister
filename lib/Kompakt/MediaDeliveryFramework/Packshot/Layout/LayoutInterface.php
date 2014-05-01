<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot\Layout;

interface LayoutInterface
{
    public function getMetadataFile();
    public function getOtherMetadataFileNames();
}