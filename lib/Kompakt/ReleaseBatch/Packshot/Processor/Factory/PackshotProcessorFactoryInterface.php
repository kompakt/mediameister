<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Processor\Factory;

use Kompakt\ReleaseBatch\Packshot\PackshotInterface;

interface PackshotProcessorFactoryInterface
{
    public function getInstance(PackshotInterface $packshot);
}