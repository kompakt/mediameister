<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Artwork\Finder\Factory;

use Kompakt\Mediameister\Entity\ReleaseInterface;
use Kompakt\Mediameister\Packshot\Layout\LayoutInterface;

interface ArtworkFinderFactoryInterface
{
    public function getInstance(LayoutInterface $layout, ReleaseInterface $release);
}