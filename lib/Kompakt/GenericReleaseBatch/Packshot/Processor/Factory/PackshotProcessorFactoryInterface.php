<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Processor\Factory;

use Kompakt\GenericReleaseBatch\Packshot\PackshotInterface;

interface PackshotProcessorFactoryInterface
{
    public function getInstance(PackshotInterface $packshot);
}