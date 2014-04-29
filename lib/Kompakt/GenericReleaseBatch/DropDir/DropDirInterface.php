<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\DropDir;

use Kompakt\GenericReleaseBatch\DropDir\Filter\BatchFilterInterface;

interface DropDirInterface
{
    public function getBatches(BatchFilterInterface $filter = null);
    public function getBatch($name);
    public function createBatch($name);
}