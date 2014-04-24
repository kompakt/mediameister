<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\DropDir\Filter;

use Kompakt\ReleaseBatch\Batch\BatchInterface;

interface BatchFilterInterface
{
    public function add(BatchInterface $batch);
    public function ignore(BatchInterface $batch);
}