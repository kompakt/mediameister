<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Tracer\Factory;

use Kompakt\GenericReleaseBatch\Packshot\PackshotInterface;

interface PackshotTracerFactoryInterface
{
    public function getInstance();
}