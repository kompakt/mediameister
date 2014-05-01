<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot;

use Kompakt\MediaDeliveryFramework\Entity\ReleaseInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface as ArtworkLoaderFactoryInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Audio\Loader\Factory\LoaderFactoryInterface as AudioLoaderFactoryInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface as MetadataLoaderFactoryInterface;
use Kompakt\MediaDeliveryFramework\Packshot\Metadata\Writer\Factory\WriterFactoryInterface as MetadataWriterFactoryInterface;
use Kompakt\MediaDeliveryFramework\Packshot\PackshotInterface;

class Packshot implements PackshotInterface
{
    protected $metadataLoaderFactory = null;
    protected $metadataWriterFactory = null;
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
        MetadataWriterFactoryInterface $metadataWriterFactory,
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
        $this->metadataWriterFactory = $metadataWriterFactory;
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

    public function save()
    {
        $this->metadataWriterFactory->getInstance($this->getRelease())->save($this->getLayout()->getMetadataFile());
    }
}