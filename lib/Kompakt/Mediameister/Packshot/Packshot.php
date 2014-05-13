<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot;

use Kompakt\Mediameister\Entity\ReleaseInterface;
use Kompakt\Mediameister\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface as ArtworkLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Audio\Loader\Factory\LoaderFactoryInterface as AudioLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface as MetadataLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface as MetadataWriterFactoryInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;

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
        $this->metadataWriterFactory->getInstance()->save($this->getRelease(), $this->getLayout()->getMetadataFile());
    }
}