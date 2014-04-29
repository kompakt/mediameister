<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot;

use Kompakt\GenericReleaseBatch\Entity\ReleaseInterface;
use Kompakt\GenericReleaseBatch\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface as ArtworkLoaderFactoryInterface;
use Kompakt\GenericReleaseBatch\Packshot\Audio\Loader\Factory\LoaderFactoryInterface as AudioLoaderFactoryInterface;
use Kompakt\GenericReleaseBatch\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\GenericReleaseBatch\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface as MetadataLoaderFactoryInterface;
use Kompakt\GenericReleaseBatch\Packshot\PackshotInterface;

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
        return $this->release;
    }

    public function getArtworkLoader()
    {
        return $this->artworkLoader;
    }

    public function getAudioLoader()
    {
        return $this->audioLoader;
    }

    public function init(ReleaseInterface $release)
    {
        $this->release = $release;
        $this->load();
        return $this;
    }

    public function load()
    {
        if (!$this->release)
        {
            $this->release = $this->metadataLoaderFactory->getInstance($this->layout)->load();
        }

        $this->artworkLoader = $this->artworkLoaderFactory->getInstance($this->layout, $this->release);
        $this->audioLoader = $this->audioLoaderFactory->getInstance($this->layout, $this->release);
        return $this;
    }
}