<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Packshot\Factory;

use Kompakt\Mediameister\Packshot\Factory\PackshotFactory;

class PackshotFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $layoutFactory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface')
            ->getMock()
        ;

        $metadataLoaderFactory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Metadata\Loader\Factory\MetadataLoaderFactoryInterface')
            ->getMock()
        ;

        $metadataWriterFactory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface')
            ->getMock()
        ;

        $artworkLocatorFactory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Artwork\Locator\Factory\ArtworkLocatorFactoryInterface')
            ->getMock()
        ;

        $audioLocatorFactory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Audio\Locator\Factory\AudioLocatorFactoryInterface')
            ->getMock()
        ;

        $zipLocatorFactory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Zip\Locator\Factory\ZipLocatorFactoryInterface')
            ->getMock()
        ;

        $packshotFactory = new PackshotFactory(
            $layoutFactory,
            $metadataWriterFactory,
            $metadataLoaderFactory,
            $artworkLocatorFactory,
            $audioLocatorFactory,
            $zipLocatorFactory
        );

        $this->assertInstanceOf('Kompakt\Mediameister\Packshot\Packshot', $packshotFactory->getInstance(__DIR__));
    }
}