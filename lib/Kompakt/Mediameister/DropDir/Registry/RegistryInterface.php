<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\DropDir\Registry;

use Kompakt\Mediameister\DropDir\DropDirInterface;

interface RegistryInterface
{
    public function add($label, DropDirInterface $dropDir);
    public function get($label);
}