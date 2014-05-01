<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot\Metadata\Loader\Factory;

use Kompakt\MediaDeliveryFramework\Packshot\Layout\LayoutInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Metadata\Reader\Factory\ReaderFactoryInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Metadata\Loader\Loader;

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