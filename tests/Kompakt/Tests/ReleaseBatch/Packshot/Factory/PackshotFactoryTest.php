<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\ReleaseBatch\Packshot\Factory;

use Kompakt\ReleaseBatch\Packshot\Factory\PackshotFactory;

class PackshotFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $layoutFactory = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Layout\Factory\LayoutFactoryInterface')
            ->getMock()
        ;

        $metadataLoaderFactory = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;

        $artworkLoaderFactory = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;

        $audioLoaderFactory = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Audio\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;

        $packshotFactory = new PackshotFactory(
            $layoutFactory,
            $metadataLoaderFactory,
            $artworkLoaderFactory,
            $audioLoaderFactory
        );

        $this->assertInstanceOf('Kompakt\ReleaseBatch\Packshot\Packshot', $packshotFactory->getInstance(__DIR__));
    }
}