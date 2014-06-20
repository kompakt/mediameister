<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Selection\Factory;

use Kompakt\Mediameister\Batch\Selection\File;

class FileFactory
{
    protected $filename = null;

    public function __construct($filename = '.selection')
    {
        $this->filename = $filename;
    }

    public function getInstance($dir)
    {
        return new File($this->filename, $dir);
    }
}