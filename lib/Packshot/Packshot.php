<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot;

use Kompakt\Mediameister\Entity\ReleaseInterface;
use Kompakt\Mediameister\Packshot\Artwork\Locator\Factory\ArtworkLocatorFactoryInterface;
use Kompakt\Mediameister\Packshot\Audio\Locator\Factory\AudioLocatorFactoryInterface;
use Kompakt\Mediameister\Packshot\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Loader\Factory\MetadataLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface as MetadataWriterFactoryInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;

class Packshot implements PackshotInterface
{
    protected $metadataWriterFactory = null;
    protected $metadataLoaderFactory = null;
    protected $artworkLocatorFactory = null;
    protected $audioLocatorFactory = null;
    protected $name = null;
    protected $layout = null;
    protected $release = null;
    protected $metadataLoader = null;
    protected $artworkLocator = null;
    protected $audioLocator = null;

    public function __construct(
        LayoutFactoryInterface $layoutFactory,
        MetadataWriterFactoryInterface $metadataWriterFactory,
        MetadataLoaderFactoryInterface $metadataLoaderFactory,
        ArtworkLocatorFactoryInterface $artworkLocatorFactory,
        AudioLocatorFactoryInterface $audioLocatorFactory,
        $dir
    )
    {
        $info = new \SplFileInfo($dir);

        if (!$info->isDir())
        {
            throw new InvalidArgumentException(sprintf('Packshot dir not found'));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('Packshot dir not readable'));
        }

        if (!$info->isWritable())
        {
            throw new InvalidArgumentException(sprintf('Packshot dir not writable'));
        }

        $this->metadataWriterFactory = $metadataWriterFactory;
        $this->metadataLoaderFactory = $metadataLoaderFactory;
        $this->artworkLocatorFactory = $artworkLocatorFactory;
        $this->audioLocatorFactory = $audioLocatorFactory;

        $this->dir = $dir;
        $this->name = basename($dir);
        $this->layout = $layoutFactory->getInstance($dir);
    }

    public function getDir()
    {
        return $this->dir;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLayout()
    {
        return $this->layout;
    }
    
    public function getRelease()
    {
        return $this->release;
    }

    public function getMetadataLoader()
    {
        return $this->metadataLoader;
    }

    public function getArtworkLocator()
    {
        return $this->artworkLocator;
    }

    public function getAudioLocator()
    {
        return $this->audioLocator;
    }

    public function init(ReleaseInterface $release)
    {
        $this->release = $release;
        $this->load();
        return $this;
    }

    public function load()
    {
        $this->metadataLoader = $this->metadataLoaderFactory->getInstance($this->layout);

        if (!$this->release)
        {
            $this->release = $this->metadataLoader->load();
        }

        $this->artworkLocator = $this->artworkLocatorFactory->getInstance($this->layout, $this->release);
        $this->audioLocator = $this->audioLocatorFactory->getInstance($this->layout, $this->release);
        return $this;
    }

    public function save()
    {
        $this->metadataWriterFactory->getInstance($this->layout, $this->release)->write();
    }
}