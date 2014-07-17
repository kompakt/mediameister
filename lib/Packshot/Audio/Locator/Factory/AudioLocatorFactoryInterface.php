<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Audio\Locator\Factory;

use Kompakt\Mediameister\Entity\ReleaseInterface;
use Kompakt\Mediameister\Packshot\Layout\LayoutInterface;

interface AudioLocatorFactoryInterface
{
    public function getInstance(LayoutInterface $layout, ReleaseInterface $release);
}