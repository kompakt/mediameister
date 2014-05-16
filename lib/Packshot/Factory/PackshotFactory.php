<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Factory;

use Kompakt\Mediameister\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface as ArtworkLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Audio\Loader\Factory\LoaderFactoryInterface as AudioLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Factory\PackshotFactoryInterface;
use Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface as MetadataLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface as MetadataWriterFactoryInterface;
use Kompakt\Mediameister\Packshot\Packshot;

class PackshotFactory implements PackshotFactoryInterface
{
    protected $layoutFactory = null;
    protected $metadataLoaderFactory = null;
    protected $metadataWriterFactory = null;
    protected $artworkLoaderFactory = null;
    protected $audioLoaderFactory = null;

    public function __construct(
        LayoutFactoryInterface $layoutFactory,
        MetadataLoaderFactoryInterface $metadataLoaderFactory,
        MetadataWriterFactoryInterface $metadataWriterFactory,
        ArtworkLoaderFactoryInterface $artworkLoaderFactory,
        AudioLoaderFactoryInterface $audioLoaderFactory
    )
    {
        $this->layoutFactory = $layoutFactory;
        $this->metadataLoaderFactory = $metadataLoaderFactory;
        $this->metadataWriterFactory = $metadataWriterFactory;
        $this->artworkLoaderFactory = $artworkLoaderFactory;
        $this->audioLoaderFactory = $audioLoaderFactory;
    }

    public function getInstance($dir)
    {
        return new Packshot(
            $this->layoutFactory,
            $this->metadataLoaderFactory,
            $this->metadataWriterFactory,
            $this->artworkLoaderFactory,
            $this->audioLoaderFactory,
            $dir
        );
    }
}