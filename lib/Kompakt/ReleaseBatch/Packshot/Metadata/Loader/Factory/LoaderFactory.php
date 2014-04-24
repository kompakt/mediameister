<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Factory;

use Kompakt\ReleaseBatch\Packshot\Layout\LayoutInterface;
use Kompakt\ReleaseBatch\Packshot\Metadata\Reader\Factory\ReaderFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Loader;

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