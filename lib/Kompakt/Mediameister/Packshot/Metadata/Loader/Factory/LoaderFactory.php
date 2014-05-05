<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Metadata\Loader\Factory;

use Kompakt\Mediameister\Packshot\Layout\LayoutInterface;
use Kompakt\Mediameister\Packshot\Metadata\Reader\Factory\ReaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Loader\Loader;

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