<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Processor;

use Kompakt\GenericReleaseBatch\Batch\BatchInterface;
use Kompakt\GenericReleaseBatch\Batch\Filter\PackshotFilterInterface;

interface BatchProcessorInterface
{
    public function process(BatchInterface $batch, PackshotFilterInterface $filter = null);
}