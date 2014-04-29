<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch;

use Kompakt\GenericReleaseBatch\Batch\Filter\PackshotFilterInterface;
use Kompakt\GenericReleaseBatch\Entity\ReleaseInterface;

interface BatchInterface
{
    public function getDir();
    public function getName();
    public function getPackshots(PackshotFilterInterface $filter = null);
    public function createPackshot($name, ReleaseInterface $release);
}