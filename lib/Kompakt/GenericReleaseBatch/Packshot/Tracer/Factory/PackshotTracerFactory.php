<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Tracer\Factory;

use Kompakt\GenericReleaseBatch\Packshot\Tracer\Factory\PackshotTracerFactoryInterface;
use Kompakt\GenericReleaseBatch\Packshot\Tracer\PackshotTracer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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