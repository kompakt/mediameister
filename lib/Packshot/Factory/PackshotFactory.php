<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Factory;

use Kompakt\Mediameister\Packshot\Artwork\Finder\Factory\ArtworkFinderFactoryInterface;
use Kompakt\Mediameister\Packshot\Audio\Finder\Factory\AudioFinderFactoryInterface;
use Kompakt\Mediameister\Packshot\Factory\PackshotFactoryInterface;
use Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Finder\Factory\MetadataFinderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface as MetadataWriterFactoryInterface;
use Kompakt\Mediameister\Packshot\Packshot;

class PackshotFactory implements PackshotFactoryInterface
{
    protected $layoutFactory = null;
    protected $metadataWriterFactory = null;
    protected $metadataFinderFactory = null;
    protected $artworkFinderFactory = null;
    protected $audioFinderFactory = null;

    public function __construct(
        LayoutFactoryInterface $layoutFactory,
        MetadataWriterFactoryInterface $metadataWriterFactory,
        MetadataFinderFactoryInterface $metadataFinderFactory,
        ArtworkFinderFactoryInterface $artworkFinderFactory,
        AudioFinderFactoryInterface $audioFinderFactory
    )
    {
        $this->layoutFactory = $layoutFactory;
        $this->metadataWriterFactory = $metadataWriterFactory;
        $this->metadataFinderFactory = $metadataFinderFactory;
        $this->artworkFinderFactory = $artworkFinderFactory;
        $this->audioFinderFactory = $audioFinderFactory;
    }

    public function getInstance($dir)
    {
        return new Packshot(
            $this->layoutFactory,
            $this->metadataWriterFactory,
            $this->metadataFinderFactory,
            $this->artworkFinderFactory,
            $this->audioFinderFactory,
            $dir
        );
    }
}