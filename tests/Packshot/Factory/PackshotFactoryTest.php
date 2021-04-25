<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Packshot\Factory;

use Kompakt\Mediameister\Packshot\Factory\PackshotFactory;
use PHPUnit\Framework\TestCase;

class PackshotFactoryTest extends TestCase
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

        $packshotFactory = new PackshotFactory(
            $layoutFactory,
            $metadataWriterFactory,
            $metadataLoaderFactory
        );

        $this->assertInstanceOf('Kompakt\Mediameister\Packshot\Packshot', $packshotFactory->getInstance(__DIR__));
    }
}