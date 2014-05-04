<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot\Tracer\Factory;

use Kompakt\MediaDeliveryFramework\Packshot\Tracer\Factory\PackshotTracerFactoryInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Tracer\PackshotTracer;
use Kompakt\MediaDeliveryFramework\EventDispatcher\EventDispatcherInterface;

class PackshotTracerFactory implements PackshotTracerFactoryInterface
{
    protected $dispatcher = null;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getInstance()
    {
        return new PackshotTracer($this->dispatcher);
    }
}