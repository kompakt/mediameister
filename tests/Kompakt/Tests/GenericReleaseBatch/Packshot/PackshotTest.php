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
            $this->getMetadataWriterFactory(),
            $this->getArtworkLoaderFactory(),
            $this->getAudioLoaderFactory(),
            __DIR__
        );

        $packshot->load();
        $packshot->getRelease();
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
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Entity\ReleaseInterface')
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

    protected function getMetadataWriterFactory()
    {
        $release = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $writer = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Metadata\Writer\WriterInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Metadata\Writer\Factory\WriterFactoryInterface')
            ->getMock()
        ;

        $factory
            ->expects($this->any())
            ->method('getInstance')
            ->will($this->returnValue($writer))
        ;

        return $factory;
    }

    public function getArtworkLoaderFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;
    }

    public function getAudioLoaderFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Audio\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;
    }
}