<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Tracer\Factory;

use Kompakt\GenericReleaseBatch\Batch\BatchInterface;

interface BatchTracerFactoryInterface
{
    public function getInstance();
}