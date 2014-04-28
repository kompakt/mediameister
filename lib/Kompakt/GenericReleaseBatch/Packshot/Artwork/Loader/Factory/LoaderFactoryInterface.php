<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Artwork\Loader\Factory;

use Kompakt\GenericReleaseBatch\Entity\ReleaseInterface;
use Kompakt\GenericReleaseBatch\Packshot\Layout\LayoutInterface;

interface LoaderFactoryInterface
{
    public function getInstance(LayoutInterface $layout, ReleaseInterface $release);
}