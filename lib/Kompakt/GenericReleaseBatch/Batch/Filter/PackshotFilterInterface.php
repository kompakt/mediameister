<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Filter;

use Kompakt\GenericReleaseBatch\Packshot\PackshotInterface;

interface PackshotFilterInterface
{
    public function add(PackshotInterface $packshot);
    public function ignore(PackshotInterface $packshot);
}