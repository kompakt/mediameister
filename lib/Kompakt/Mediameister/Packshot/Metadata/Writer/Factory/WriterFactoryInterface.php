<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Metadata\Writer\Factory;

use Kompakt\Mediameister\Entity\ReleaseInterface;

interface WriterFactoryInterface
{
    public function getInstance(ReleaseInterface $release);
}