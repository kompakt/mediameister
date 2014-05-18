<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Packshot;

use Kompakt\Mediameister\Packshot\Packshot;

class PackshotTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $packshot = new Packshot(
            $this->getLayoutFactory(),
            $this->getMetadataWriterFactory(),
            $this->getMetadataLoaderFactory(),
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
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Layout\LayoutInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Layout\Factory\LayoutFactoryInterface')
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
            ->getMockBuilder('Kompakt\Mediameister\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $loader = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Metadata\Loader\LoaderInterface')
            ->getMock()
        ;

        $loader
            ->expects($this->once())
            ->method('load')
            ->will($this->returnValue($release))
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Metadata\Loader\Factory\LoaderFactoryInterface')
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
        $writer = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Metadata\Writer\WriterInterface')
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Metadata\Writer\Factory\WriterFactoryInterface')
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
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Artwork\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;
    }

    public function getAudioLoaderFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Audio\Loader\Factory\LoaderFactoryInterface')
            ->getMock()
        ;
    }
}