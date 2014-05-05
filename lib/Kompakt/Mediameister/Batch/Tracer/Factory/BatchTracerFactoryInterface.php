<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer\Factory;

use Kompakt\Mediameister\Batch\BatchInterface;

interface BatchTracerFactoryInterface
{
    public function getInstance();
}