<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Processor\Factory;

use Kompakt\GenericReleaseBatch\Packshot\PackshotInterface;
use Kompakt\GenericReleaseBatch\Packshot\Processor\Factory\PackshotProcessorFactoryInterface;
use Kompakt\GenericReleaseBatch\Packshot\Processor\PackshotProcessor;
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