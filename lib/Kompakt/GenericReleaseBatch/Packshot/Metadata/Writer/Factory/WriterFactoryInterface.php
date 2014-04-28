<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Metadata\Writer\Factory;

use Kompakt\GenericReleaseBatch\Entity\ReleaseInterface;

interface WriterFactoryInterface
{
    public function getInstance(ReleaseInterface $release);
}