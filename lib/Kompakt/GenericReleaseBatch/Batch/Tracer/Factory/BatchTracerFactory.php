<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Tracer\Factory;

use Kompakt\GenericReleaseBatch\Batch\BatchInterface;
use Kompakt\GenericReleaseBatch\Batch\Tracer\BatchTracer;
use Kompakt\GenericReleaseBatch\Batch\Tracer\Factory\BatchtracerFactoryInterface;
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