<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Layout;

interface LayoutInterface
{
    public function getMetadataFile();
    public function getOtherMetadataFileNames();
}