<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Artwork\Loader\Factory;

use Kompakt\ReleaseBatch\Entity\Release;
use Kompakt\ReleaseBatch\Packshot\Layout\LayoutInterface;

interface LoaderFactoryInterface
{
    public function getInstance(LayoutInterface $layout, Release $release);
}