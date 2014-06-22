<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Factory;

use Kompakt\Mediameister\Batch\Batch;
use Kompakt\Mediameister\Batch\Factory\BatchFactoryInterface;
use Kompakt\Mediameister\Packshot\Factory\PackshotFactoryInterface;
use Kompakt\Mediameister\Util\Filesystem\Factory\DirectoryFactory;

class BatchFactory implements BatchFactoryInterface
{
    protected $packshotFactory = null;
    protected $directoryFactory = null;

    public function __construct(PackshotFactoryInterface $packshotFactory, DirectoryFactory $directoryFactory)
    {
        $this->packshotFactory = $packshotFactory;
        $this->directoryFactory = $directoryFactory;
    }

    public function getInstance($dir)
    {
        return new Batch($this->packshotFactory, $this->directoryFactory, $dir);
    }
}