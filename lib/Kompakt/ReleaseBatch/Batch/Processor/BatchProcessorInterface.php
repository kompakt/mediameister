<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Batch\Processor;

use Kompakt\ReleaseBatch\Batch\Filter\PackshotFilterInterface;

interface BatchProcessorInterface
{
    public function process(PackshotFilterInterface $filter = null);
}