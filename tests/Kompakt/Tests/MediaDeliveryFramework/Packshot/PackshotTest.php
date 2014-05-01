<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\MediaDeliveryFramework\Packshot;

use Kompakt\MediaDeliveryFramework\Packshot\Packshot;

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
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Layout\LayoutInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Layout\Factory\LayoutFactoryInterface')
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
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $loader = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Metadata\Loader\LoaderInterface')
            ->getMock()
        ;

        $loader
            ->expects($this->once())
            ->method('load')
            ->will($this->returnValue($release))
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface')
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
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $writer = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Metadata\Writer\WriterInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Metadata\Writer\Factory\WriterFactoryInterface')
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
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;
    }

    public function getAudioLoaderFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Audio\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;
    }
}