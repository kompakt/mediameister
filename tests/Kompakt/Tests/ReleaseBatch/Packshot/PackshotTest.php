<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\ReleaseBatch\Packshot;

use Kompakt\ReleaseBatch\Packshot\Packshot;

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
        
        $this->assertInstanceOf('Kompakt\ReleaseBatch\Packshot\Layout\LayoutInterface', $packshot->getLayout());
        $this->assertInstanceOf('Kompakt\ReleaseBatch\Entity\Release', $packshot->getRelease());
        $this->assertInstanceOf('Kompakt\ReleaseBatch\Packshot\Artwork\Loader\LoaderInterface', $packshot->getArtworkLoader());
        $this->assertInstanceOf('Kompakt\ReleaseBatch\Packshot\Audio\Loader\LoaderInterface', $packshot->getAudioLoader());
    }

    protected function getLayoutFactory()
    {
        $layout = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Layout\LayoutInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Layout\Factory\LayoutFactoryInterface')
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
            ->getMockBuilder('Kompakt\ReleaseBatch\Entity\Release')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $loader = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Metadata\Loader\LoaderInterface')
            ->getMock()
        ;

        $loader
            ->expects($this->once())
            ->method('load')
            ->will($this->returnValue($release))
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface')
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
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Artwork\Loader\LoaderInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface')
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
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Audio\Loader\LoaderInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Audio\Loader\Factory\LoaderFactoryInterface')
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