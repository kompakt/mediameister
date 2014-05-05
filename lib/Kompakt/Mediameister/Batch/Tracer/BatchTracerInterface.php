<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Filter\PackshotFilterInterface;

interface BatchTracerInterface
{
    public function trace(BatchInterface $batch, PackshotFilterInterface $filter = null);
}