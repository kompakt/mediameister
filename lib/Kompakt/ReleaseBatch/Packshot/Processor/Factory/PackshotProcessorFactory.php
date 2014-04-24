<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Processor\Factory;

use Kompakt\ReleaseBatch\Packshot\PackshotInterface;
use Kompakt\ReleaseBatch\Packshot\Processor\Factory\PackshotProcessorFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Processor\PackshotProcessor;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PackshotProcessorFactory implements PackshotProcessorFactoryInterface
{
    protected $dispatcher = null;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getInstance(PackshotInterface $packshot)
    {
        return new PackshotProcessor($this->dispatcher, $packshot);
    }
}