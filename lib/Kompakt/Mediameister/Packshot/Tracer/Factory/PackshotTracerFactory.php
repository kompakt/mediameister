<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Tracer\Factory;

use Kompakt\Mediameister\Packshot\Tracer\Factory\PackshotTracerFactoryInterface;
use Kompakt\Mediameister\Packshot\Tracer\PackshotTracer;
use Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface;

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