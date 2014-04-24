<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Batch\Filter;

use Kompakt\ReleaseBatch\Packshot\PackshotInterface;

interface PackshotFilterInterface
{
    public function add(PackshotInterface $packshot);
    public function ignore(PackshotInterface $packshot);
}