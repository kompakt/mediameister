<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Audio\Finder\Factory;

use Kompakt\Mediameister\Entity\ReleaseInterface;
use Kompakt\Mediameister\Packshot\Layout\LayoutInterface;

interface AudioFinderFactoryInterface
{
    public function getInstance(LayoutInterface $layout, ReleaseInterface $release);
}