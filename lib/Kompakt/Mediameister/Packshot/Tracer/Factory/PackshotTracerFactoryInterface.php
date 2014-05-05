<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Tracer\Factory;

use Kompakt\Mediameister\Packshot\PackshotInterface;

interface PackshotTracerFactoryInterface
{
    public function getInstance();
}