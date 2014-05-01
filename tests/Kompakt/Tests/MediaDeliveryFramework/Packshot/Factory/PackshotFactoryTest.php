<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\MediaDeliveryFramework\Packshot\Factory;

use Kompakt\MediaDeliveryFramework\Packshot\Factory\PackshotFactory;

class PackshotFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $layoutFactory = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Layout\Factory\LayoutFactoryInterface')
            ->getMock()
        ;

        $metadataLoaderFactory = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;

        $metadataWriterFactory = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Metadata\Writer\Factory\WriterFactoryInterface')
            ->getMock()
        ;

        $artworkLoaderFactory = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;

        $audioLoaderFactory = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Audio\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;

        $packshotFactory = new PackshotFactory(
            $layoutFactory,
            $metadataLoaderFactory,
            $metadataWriterFactory,
            $artworkLoaderFactory,
            $audioLoaderFactory
        );

        $this->assertInstanceOf('Kompakt\MediaDeliveryFramework\Packshot\Packshot', $packshotFactory->getInstance(__DIR__));
    }
}