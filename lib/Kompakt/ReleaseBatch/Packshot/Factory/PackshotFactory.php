<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Factory;

use Kompakt\ReleaseBatch\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface as ArtworkLoaderFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Audio\Loader\Factory\LoaderFactoryInterface as AudioLoaderFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Factory\PackshotFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface as MetadataLoaderFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Packshot;

class PackshotFactory implements PackshotFactoryInterface
{
    protected $layoutFactory = null;
    protected $metadataLoaderFactory = null;
    protected $artworkLoaderFactory = null;
    protected $audioLoaderFactory = null;

    public function __construct(
        LayoutFactoryInterface $layoutFactory,
        MetadataLoaderFactoryInterface $metadataLoaderFactory,
        ArtworkLoaderFactoryInterface $artworkLoaderFactory,
        AudioLoaderFactoryInterface $audioLoaderFactory
    )
    {
        $this->layoutFactory = $layoutFactory;
        $this->metadataLoaderFactory = $metadataLoaderFactory;
        $this->artworkLoaderFactory = $artworkLoaderFactory;
        $this->audioLoaderFactory = $audioLoaderFactory;
    }

    public function getInstance($dir)
    {
        return new Packshot(
            $this->layoutFactory,
            $this->metadataLoaderFactory,
            $this->artworkLoaderFactory,
            $this->audioLoaderFactory,
            $dir
        );
    }
}