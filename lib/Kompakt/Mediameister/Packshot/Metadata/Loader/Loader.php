<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Metadata\Loader;

use Kompakt\Mediameister\Packshot\Layout\LayoutInterface;
use Kompakt\Mediameister\Packshot\Metadata\Reader\Factory\ReaderFactoryInterface;
use Kompakt\Mediameister\Packshot\Metadata\Loader\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Packshot\Metadata\Loader\LoaderInterface;

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