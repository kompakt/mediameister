<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Tracer;

use Kompakt\GenericReleaseBatch\Batch\BatchInterface;
use Kompakt\GenericReleaseBatch\Batch\Filter\PackshotFilterInterface;

interface BatchTracerInterface
{
    public function process(BatchInterface $batch, PackshotFilterInterface $filter = null);
}