<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\GenericReleaseBatch\Packshot;

use Kompakt\GenericReleaseBatch\Packshot\Packshot;

class PackshotTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $packshot = new Packshot(
            $this->getLayoutFactory(),
            $this->getMetadataLoaderFactory(),
            $this->getArtworkLoaderFactory(),
            $this->getAudioLoaderFactory(),
            __DIR__
        );
        
        $this->assertInstanceOf('Kompakt\GenericReleaseBatch\Packshot\Layout\LayoutInterface', $packshot->getLayout());
        $this->assertInstanceOf('Kompakt\ReleaseBatchModel\ReleaseInterface', $packshot->getRelease());
        $this->assertInstanceOf('Kompakt\GenericReleaseBatch\Packshot\Artwork\Loader\LoaderInterface', $packshot->getArtworkLoader());
        $this->assertInstanceOf('Kompakt\GenericReleaseBatch\Packshot\Audio\Loader\LoaderInterface', $packshot->getAudioLoader());
    }

    protected function getLayoutFactory()
    {
        $layout = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Layout\LayoutInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Layout\Factory\LayoutFactoryInterface')
            ->getMock()
        ;

        $factory
            ->expects($this->once())
            ->method('getInstance')
            ->will($this->returnValue($layout))
        ;

        return $factory;
    }

    protected function getMetadataLoaderFactory()
    {
        $release = $this
            ->getMockBuilder('Kompakt\ReleaseBatchModel\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $loader = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Metadata\Loader\LoaderInterface')
            ->getMock()
        ;

        $loader
            ->expects($this->once())
            ->method('load')
            ->will($this->returnValue($release))
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;

        $factory
            ->expects($this->once())
            ->method('getInstance')
            ->will($this->returnValue($loader))
        ;

        return $factory;
    }

    public function getArtworkLoaderFactory()
    {
        $loader = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Artwork\Loader\LoaderInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;

        $factory
            ->expects($this->once())
            ->method('getInstance')
            ->will($this->returnValue($loader))
        ;

        return $factory;
    }

    public function getAudioLoaderFactory()
    {
        $loader = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Audio\Loader\LoaderInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Audio\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;

        $factory
            ->expects($this->once())
            ->method('getInstance')
            ->will($this->returnValue($loader))
        ;

        return $factory;
    }
}