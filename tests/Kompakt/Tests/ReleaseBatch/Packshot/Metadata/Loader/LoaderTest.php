<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\ReleaseBatch\Packshot\Metadata\Loader;

use Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Loader;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadWithStandardMetadataFilename()
    {
        $layout = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Layout\LayoutInterface')
            ->getMock()
        ;

        $layout
            ->expects($this->any())
            ->method('getMetadataFile')
            ->will($this->returnValue(sprintf('%s/_files/LoaderTest/my-meta.xml', __DIR__)))
        ;

        $metadataReaderFactory = $this->getMetadataReaderFactory();
        $loader = new Loader($metadataReaderFactory, $layout);
        $this->assertInstanceOf('Kompakt\ReleaseBatch\Entity\Release', $loader->load());
    }

    public function testLoadWithOtherMetadataFilename()
    {
        $layout = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Layout\LayoutInterface')
            ->getMock()
        ;

        $layout
            ->expects($this->any())
            ->method('getMetadataFile')
            ->will($this->returnValue(sprintf('%s/_files/LoaderTest/some-non-existing-meta.xml', __DIR__)))
        ;

        $layout
            ->expects($this->any())
            ->method('getOtherMetadataFileNames')
            ->will($this->returnValue(array('my-meta.xml')))
        ;

        $metadataReaderFactory = $this->getMetadataReaderFactory();
        $loader = new Loader($metadataReaderFactory, $layout);
        $this->assertInstanceOf('Kompakt\ReleaseBatch\Entity\Release', $loader->load());
    }

    protected function getMetadataReaderFactory()
    {
        $release = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Entity\Release')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $metadataReader = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Metadata\Reader\ReaderInterface')
            ->getMock()
        ;

        $metadataReader
            ->expects($this->any())
            ->method('load')
            ->will($this->returnValue($release))
        ;

        $metadataReaderFactory = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Metadata\Reader\Factory\ReaderFactoryInterface')
            ->getMock()
        ;

        $metadataReaderFactory
            ->expects($this->any())
            ->method('getInstance')
            ->will($this->returnValue($metadataReader))
        ;

        return $metadataReaderFactory;
    }
}