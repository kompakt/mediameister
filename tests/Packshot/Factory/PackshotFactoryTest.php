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

        $artworkFinderFactory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Artwork\Finder\Factory\ArtworkFinderFactoryInterface')
            ->getMock()
        ;

        $audioFinderFactory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Audio\Finder\Factory\AudioFinderFactoryInterface')
            ->getMock()
        ;

        $packshotFactory = new PackshotFactory(
            $layoutFactory,
            $metadataWriterFactory,
            $metadataLoaderFactory,
            $artworkFinderFactory,
            $audioFinderFactory
        );

        $this->assertInstanceOf('Kompakt\Mediameister\Packshot\Packshot', $packshotFactory->getInstance(__DIR__));
    }
}