<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\DropDir;

use Kompakt\Mediameister\DropDir\Filter\BatchFilterInterface;

interface DropDirInterface
{
    public function getDir();
    public function getBatches(BatchFilterInterface $filter = null);
    public function getBatch($name);
    public function createBatch($name);
    public function deleteBatch($name);
}