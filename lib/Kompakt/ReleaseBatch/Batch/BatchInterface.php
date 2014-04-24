<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Batch;

use Kompakt\ReleaseBatch\Batch\Filter\PackshotFilterInterface;

interface BatchInterface
{
    public function getDir();
    public function getName();
    public function getPackshots(PackshotFilterInterface $filter = null);
    public function createPackshot($name, $mode = 0777);
}