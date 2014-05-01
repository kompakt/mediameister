<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Factory;

use Kompakt\MediaDeliveryFramework\Batch\Batch;
use Kompakt\MediaDeliveryFramework\Batch\Factory\BatchFactoryInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Factory\PackshotFactoryInterface;

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