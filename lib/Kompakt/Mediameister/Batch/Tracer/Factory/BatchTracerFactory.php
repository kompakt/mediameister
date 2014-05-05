<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer\Factory;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Batch\Tracer\BatchTracer;
use Kompakt\Mediameister\Batch\Tracer\Factory\BatchtracerFactoryInterface;
use Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface;

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