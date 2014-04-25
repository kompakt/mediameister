<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\DropDir\Filter;

use Kompakt\GenericReleaseBatch\Batch\BatchInterface;

interface BatchFilterInterface
{
    public function add(BatchInterface $batch);
    public function ignore(BatchInterface $batch);
}