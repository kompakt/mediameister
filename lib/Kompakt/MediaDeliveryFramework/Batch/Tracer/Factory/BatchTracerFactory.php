<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Tracer\Factory;

use Kompakt\MediaDeliveryFramework\Batch\BatchInterface;
use Kompakt\MediaDeliveryFramework\Batch\Tracer\BatchTracer;
use Kompakt\MediaDeliveryFramework\Batch\Tracer\Factory\BatchtracerFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BatchTracerFactory implements BatchtracerFactoryInterface
{
    protected $dispatcher = null;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getInstance()
    {
        return new BatchTracer($this->dispatcher);
    }
}