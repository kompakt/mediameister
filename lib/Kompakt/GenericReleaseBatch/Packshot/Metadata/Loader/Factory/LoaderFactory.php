<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot\Metadata\Loader\Factory;

use Kompakt\GenericReleaseBatch\Packshot\Layout\LayoutInterface;
use Kompakt\GenericReleaseBatch\Packshot\Metadata\Reader\Factory\ReaderFactoryInterface;
use Kompakt\GenericReleaseBatch\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface;
use Kompakt\GenericReleaseBatch\Packshot\Metadata\Loader\Loader;

class LoaderFactory implements LoaderFactoryInterface
{
    protected $metadataReaderFactory = null;

    public function __construct(ReaderFactoryInterface $metadataReaderFactory)
    {
        $this->metadataReaderFactory = $metadataReaderFactory;
    }

    public function getInstance(LayoutInterface $layout)
    {
        return new Loader($this->metadataReaderFactory, $layout);
    }
}