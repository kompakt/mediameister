<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot;

use Kompakt\Mediameister\Entity\ReleaseInterface;
use Kompakt\Mediameister\Packshot\Artwork\Finder\Factory\ArtworkFinderFactoryInterface;
use Kompakt\Mediameister\Packshot\Audio\Finder\Factory\AudioFinderFactoryInterface;
use Kompakt\Mediameister\Packshot\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Finder\Factory\MetadataFinderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface as MetadataWriterFactoryInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;

class Packshot implements PackshotInterface
{
    protected $metadataWriterFactory = null;
    protected $metadataFinderFactory = null;
    protected $artworkFinderFactory = null;
    protected $audioFinderFactory = null;
    protected $name = null;
    protected $layout = null;
    protected $release = null;
    protected $artworkFinder = null;
    protected $audioFinder = null;

    public function __construct(
        LayoutFactoryInterface $layoutFactory,
        MetadataWriterFactoryInterface $metadataWriterFactory,
        MetadataFinderFactoryInterface $metadataFinderFactory,
        ArtworkFinderFactoryInterface $artworkFinderFactory,
        AudioFinderFactoryInterface $audioFinderFactory,
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

        $this->metadataFinderFactory = $metadataFinderFactory;
        $this->metadataWriterFactory = $metadataWriterFactory;
        $this->artworkFinderFactory = $artworkFinderFactory;
        $this->audioFinderFactory = $audioFinderFactory;
        
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

    public function getArtworkFinder()
    {
        return $this->artworkFinder;
    }

    public function getAudioFinder()
    {
        return $this->audioFinder;
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
            $this->release = $this->metadataFinderFactory->getInstance($this->layout)->find();
        }

        $this->artworkFinder = $this->artworkFinderFactory->getInstance($this->layout, $this->release);
        $this->audioFinder = $this->audioFinderFactory->getInstance($this->layout, $this->release);
        return $this;
    }

    public function save()
    {
        $this->metadataWriterFactory->getInstance($this->layout, $this->release)->write();
    }
}