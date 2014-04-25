<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Processor\Factory;

use Kompakt\GenericReleaseBatch\Batch\BatchInterface;
use Kompakt\GenericReleaseBatch\Batch\Processor\BatchProcessor;
use Kompakt\GenericReleaseBatch\Batch\Processor\Factory\BatchprocessorFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BatchProcessorFactory implements BatchprocessorFactoryInterface
{
    protected $dispatcher = null;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getInstance(BatchInterface $batch)
    {
        return new BatchProcessor($this->dispatcher, $batch);
    }
}