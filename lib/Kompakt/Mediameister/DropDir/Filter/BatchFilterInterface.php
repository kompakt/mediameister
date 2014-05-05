<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\DropDir\Filter;

use Kompakt\Mediameister\Batch\BatchInterface;

interface BatchFilterInterface
{
    public function add(BatchInterface $batch);
    public function ignore(BatchInterface $batch);
}