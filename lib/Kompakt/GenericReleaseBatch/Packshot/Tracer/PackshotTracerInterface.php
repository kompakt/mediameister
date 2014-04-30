<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Tracer;

use Kompakt\GenericReleaseBatch\Packshot\PackshotInterface;

interface PackshotTracerInterface
{
    public function process(PackshotInterface $packshot);
}