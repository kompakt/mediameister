<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Metadata\Loader;

use Kompakt\ReleaseBatch\Packshot\Metadata\Reader\Factory\ReaderFactoryInterface;
use Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Exception\InvalidArgumentException;
use Kompakt\ReleaseBatch\Packshot\Metadata\Loader\LoaderInterface;
use Kompakt\ReleaseBatch\Packshot\Layout\LayoutInterface;

class Loader implements LoaderInterface
{
    protected $metadataReaderFactory = null;
    protected $layout = null;

    public function __construct(
        ReaderFactoryInterface $metadataReaderFactory,
        LayoutInterface $layout
    )
    {
        $this->metadataReaderFactory = $metadataReaderFactory;
        $this->layout = $layout;
    }

    public function load()
    {
        $pathname = $this->layout->getMetadataFile();
        $fileInfo = new \SplFileInfo($pathname);

        if ($fileInfo->isFile())
        {
            return $this->metadataReaderFactory->getInstance($pathname)->load();
        }

        foreach ($this->layout->getOtherMetadataFileNames() as $name)
        {
            $pathname = sprintf('%s/%s', dirname($pathname), $name);
            $fileInfo = new \SplFileInfo($pathname);

            if ($fileInfo->isFile())
            {
                return $this->metadataReaderFactory->getInstance($pathname)->load();
            }
        }

        throw new InvalidArgumentException('Metadata file not found');
    }
}