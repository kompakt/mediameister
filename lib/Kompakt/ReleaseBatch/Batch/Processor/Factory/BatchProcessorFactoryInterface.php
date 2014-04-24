<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Batch\Processor\Factory;

use Kompakt\ReleaseBatch\Batch\BatchInterface;

interface BatchProcessorFactoryInterface
{
    public function getInstance(BatchInterface $batch);
}