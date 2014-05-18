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
            $this->getMetadataFinderFactory(),
            $this->getArtworkFinderFactory(),
            $this->getAudioFinderFactory(),
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

    protected function getMetadataFinderFactory()
    {
        $release = $this
            ->getMockBuilder('Kompakt\Mediameister\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $finder = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Metadata\Finder\MetadataFinderInterface')
            ->getMock()
        ;

        $finder
            ->expects($this->once())
            ->method('find')
            ->will($this->returnValue($release))
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Metadata\Finder\Factory\MetadataFinderFactoryInterface')
            ->getMock()
        ;

        $factory
            ->expects($this->once())
            ->method('getInstance')
            ->will($this->returnValue($finder))
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

    public function getArtworkFinderFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Artwork\Finder\Factory\ArtworkFinderFactoryInterface')
            ->getMock()
        ;
    }

    public function getAudioFinderFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Audio\Finder\Factory\AudioFinderFactoryInterface')
            ->getMock()
        ;
    }
}