<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Metadata\Writer;

use Kompakt\Mediameister\Entity\ReleaseInterface;

interface WriterInterface
{
    public function save(ReleaseInterface $release, $file);
}