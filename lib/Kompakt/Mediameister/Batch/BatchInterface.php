<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch;

use Kompakt\Mediameister\Batch\Filter\PackshotFilterInterface;

interface BatchInterface
{
    public function getDir();
    public function getName();
    public function getPackshots(PackshotFilterInterface $filter = null);
    public function createPackshot($name);
}