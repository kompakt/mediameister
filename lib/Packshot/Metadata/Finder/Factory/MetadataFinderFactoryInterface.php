<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Metadata\Finder\Factory;

use Kompakt\Mediameister\Packshot\Layout\LayoutInterface;

interface MetadataFinderFactoryInterface
{
    public function getInstance(LayoutInterface $layout);
}