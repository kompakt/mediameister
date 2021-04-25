<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Factory;

use Kompakt\Mediameister\Packshot\Factory\PackshotFactoryInterface;
use Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Loader\Factory\MetadataLoaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface as MetadataWriterFactoryInterface;
use Kompakt\Mediameister\Packshot\Packshot;

class PackshotFactory implements PackshotFactoryInterface
{
    protected $layoutFactory = null;
    protected $metadataWriterFactory = null;
    protected $metadataLoaderFactory = null;

    public function __construct(
        LayoutFactoryInterface $layoutFactory,
        MetadataWriterFactoryInterface $metadataWriterFactory,
        MetadataLoaderFactoryInterface $metadataLoaderFactory
    )
    {
        $this->layoutFactory = $layoutFactory;
        $this->metadataWriterFactory = $metadataWriterFactory;
        $this->metadataLoaderFactory = $metadataLoaderFactory;
    }

    public function getInstance($dir)
    {
        return new Packshot(
            $dir,
            $this->layoutFactory,
            $this->metadataWriterFactory,
            $this->metadataLoaderFactory
        );
    }
}