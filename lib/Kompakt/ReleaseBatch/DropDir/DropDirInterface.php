<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\DropDir;

use Kompakt\ReleaseBatch\DropDir\Filter\BatchFilterInterface;

interface DropDirInterface
{
    public function getBatches(BatchFilterInterface $filter = null);
    public function getBatch($name);
    public function createBatch($name, $mode = 0777);
}