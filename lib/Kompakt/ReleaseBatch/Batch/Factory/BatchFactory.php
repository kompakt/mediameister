<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Batch\Factory;

use Kompakt\ReleaseBatch\Batch\Batch;
use Kompakt\ReleaseBatch\Batch\Factory\BatchFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Factory\PackshotFactoryInterface;

class BatchFactory implements BatchFactoryInterface
{
    protected $packshotFactory = null;

    public function __construct(PackshotFactoryInterface $packshotFactory)
    {
        $this->packshotFactory = $packshotFactory;
    }

    public function getInstance($dir)
    {
        return new Batch($this->packshotFactory, $dir);
    }
}