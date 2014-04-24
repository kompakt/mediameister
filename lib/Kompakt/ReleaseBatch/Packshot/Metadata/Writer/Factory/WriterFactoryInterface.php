<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Metadata\Writer\Factory;

use Kompakt\ReleaseBatch\Entity\Release;

interface WriterFactoryInterface
{
    public function getInstance(Release $release);
}