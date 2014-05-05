<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Filter;

use Kompakt\Mediameister\Packshot\PackshotInterface;

interface PackshotFilterInterface
{
    public function add(PackshotInterface $packshot);
    public function ignore(PackshotInterface $packshot);
}