<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\ReleaseBatch\Packshot\Processor;

use Kompakt\ReleaseBatch\Packshot\Processor\PackshotProcessor;

class PackshotProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $track = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Entity\Track')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $release = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Entity\Release')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $release
            ->expects($this->once())
            ->method('getTracks')
            ->will($this->returnValue(array($track)))
        ;

        $packshot = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\PackshotInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $packshot
            ->expects($this->once())
            ->method('getRelease')
            ->will($this->returnValue($release))
        ;

        $dispatcher = $this
            ->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $processor = new PackshotProcessor($dispatcher, $packshot);
        $processor->process();
    }
}