<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Factory;

use Kompakt\Mediameister\Packshot\Artwork\Locator\Factory\ArtworkLocatorFactoryInterface;
use Kompakt\Mediameister\Packshot\Audio\Locator\Factory\AudioLocatorFactoryInterface;
use Kompakt\Mediameister\Packshot\Factory\PackshotFactoryInterface;
use Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Loader\Factory\MetadataLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface as MetadataWriterFactoryInterface;
use Kompakt\Mediameister\Packshot\Packshot;
use Kompakt\Mediameister\Packshot\Zip\Locator\Factory\ZipLocatorFactoryInterface;

class PackshotFactory implements PackshotFactoryInterface
{
    protected $layoutFactory = null;
    protected $metadataWriterFactory = null;
    protected $metadataLoaderFactory = null;
    protected $artworkLocatorFactory = null;
    protected $audioLocatorFactory = null;
    protected $zipLocatorFactory = null;

    public function __construct(
        LayoutFactoryInterface $layoutFactory,
        MetadataWriterFactoryInterface $metadataWriterFactory,
        MetadataLoaderFactoryInterface $metadataLoaderFactory,
        ArtworkLocatorFactoryInterface $artworkLocatorFactory,
        AudioLocatorFactoryInterface $audioLocatorFactory,
        ZipLocatorFactoryInterface $zipLocatorFactory
    )
    {
        $this->layoutFactory = $layoutFactory;
        $this->metadataWriterFactory = $metadataWriterFactory;
        $this->metadataLoaderFactory = $metadataLoaderFactory;
        $this->artworkLocatorFactory = $artworkLocatorFactory;
        $this->audioLocatorFactory = $audioLocatorFactory;
        $this->zipLocatorFactory = $zipLocatorFactory;
    }

    public function getInstance($dir)
    {
        return new Packshot(
            $this->layoutFactory,
            $this->metadataWriterFactory,
            $this->metadataLoaderFactory,
            $this->artworkLocatorFactory,
            $this->audioLocatorFactory,
            $this->zipLocatorFactory,
            $dir
        );
    }
}