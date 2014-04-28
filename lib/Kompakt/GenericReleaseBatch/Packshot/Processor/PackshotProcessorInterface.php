<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Processor;

use Kompakt\GenericReleaseBatch\Packshot\PackshotInterface;

interface PackshotProcessorInterface
{
    public function process(PackshotInterface $packshot);
}