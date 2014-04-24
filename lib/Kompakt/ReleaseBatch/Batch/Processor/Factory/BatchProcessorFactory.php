<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Batch\Processor\Factory;

use Kompakt\ReleaseBatch\Batch\BatchInterface;
use Kompakt\ReleaseBatch\Batch\Processor\BatchProcessor;
use Kompakt\ReleaseBatch\Batch\Processor\Factory\BatchprocessorFactoryInterface;
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