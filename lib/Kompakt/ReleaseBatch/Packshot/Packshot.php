<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot;

use Kompakt\ReleaseBatch\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface as ArtworkLoaderFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Audio\Loader\Factory\LoaderFactoryInterface as AudioLoaderFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface as MetadataLoaderFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\PackshotInterface;

class Packshot implements PackshotInterface
{
    protected $metadataLoaderFactory = null;
    protected $artworkLoaderFactory = null;
    protected $audioLoaderFactory = null;
    protected $name = null;
    protected $layout = null;
    protected $release = null;
    protected $artworkLoader = null;
    protected $audioLoader = null;
    protected $loaded = false;

    public function __construct(
        LayoutFactoryInterface $layoutFactory,
        MetadataLoaderFactoryInterface $metadataLoaderFactory,
        ArtworkLoaderFactoryInterface $artworkLoaderFactory,
        AudioLoaderFactoryInterface $audioLoaderFactory,
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

        $this->metadataLoaderFactory = $metadataLoaderFactory;
        $this->artworkLoaderFactory = $artworkLoaderFactory;
        $this->audioLoaderFactory = $audioLoaderFactory;
        
        $this->name = basename($dir);
        $this->layout = $layoutFactory->getInstance($dir);
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
        $this->load();
        return $this->release;
    }

    public function getArtworkLoader()
    {
        $this->load();
        return $this->artworkLoader;
    }

    public function getAudioLoader()
    {
        $this->load();
        return $this->audioLoader;
    }

    protected function load()
    {
        if ($this->loaded)
        {
            return $this;
        }

        $this->loaded = true;
        $this->release = $this->metadataLoaderFactory->getInstance($this->getLayout())->load();
        $this->artworkLoader = $this->artworkLoaderFactory->getInstance($this->getLayout(), $this->release);
        $this->audioLoader = $this->audioLoaderFactory->getInstance($this->getLayout(), $this->release);
        return $this;
    }
}