<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Factory;

use Kompakt\GenericReleaseBatch\Batch\Batch;
use Kompakt\GenericReleaseBatch\Batch\Factory\BatchFactoryInterface;
use Kompakt\GenericReleaseBatch\Packshot\Factory\PackshotFactoryInterface;

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