<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Util\Archive\Factory;

use Kompakt\Mediameister\Util\Archive\FileAdder;

class FileAdderFactory
{
    public function getInstance(\ZipArchive $zip)
    {
        return new FileAdder($zip);
    }
}