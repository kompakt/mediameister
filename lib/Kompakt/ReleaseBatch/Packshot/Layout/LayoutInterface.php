<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Layout;

interface LayoutInterface
{
    public function getMetadataFile();
    public function getOtherMetadataFileNames();
}