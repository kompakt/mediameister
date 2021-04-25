<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot;

use Kompakt\Mediameister\Entity\ReleaseInterface;
use Kompakt\Mediameister\Packshot\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Loader\Factory\MetadataLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface as MetadataWriterFactoryInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;

class Packshot implements PackshotInterface
{
    protected $metadataWriterFactory = null;
    protected $metadataLoaderFactory = null;
    protected $dir = null;
    protected $name = null;
    protected $layout = null;
    protected $release = null;
    protected $metadataLoader = null;

    public function __construct(
        $dir,
        LayoutFactoryInterface $layoutFactory,
        MetadataWriterFactoryInterface $metadataWriterFactory,
        MetadataLoaderFactoryInterface $metadataLoaderFactory
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

        return $this;
    }

    public function save()
    {
        $this->metadataWriterFactory->getInstance($this->layout, $this->release)->write();
    }
}