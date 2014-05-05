<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\DropDir\Registry;

use Kompakt\Mediameister\DropDir\DropDirInterface;
use Kompakt\Mediameister\DropDir\Registry\RegistryInterface;

class Registry implements RegistryInterface
{
    protected $dropDirs = array();

    public function add($label, DropDirInterface $dropDir)
    {
        $this->dropDirs[$label] = $dropDir;
    }

    public function get($label)
    {
        if (array_key_exists($label, $this->dropDirs))
        {
            return $this->dropDirs[$label];
        }

        return null;
    }
}