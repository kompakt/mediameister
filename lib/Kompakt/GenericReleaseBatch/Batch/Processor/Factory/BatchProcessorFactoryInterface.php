<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Processor\Factory;

use Kompakt\GenericReleaseBatch\Batch\BatchInterface;

interface BatchProcessorFactoryInterface
{
    public function getInstance(BatchInterface $batch);
}