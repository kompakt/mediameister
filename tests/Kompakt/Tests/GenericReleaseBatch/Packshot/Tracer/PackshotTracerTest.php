<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\GenericReleaseBatch\Packshot\Tracer;

use Kompakt\GenericReleaseBatch\Packshot\Tracer\PackshotTracer;

class PackshotTracerTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $track = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Entity\TrackInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $release = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $release
            ->expects($this->once())
            ->method('getTracks')
            ->will($this->returnValue(array($track)))
        ;

        $packshot = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\PackshotInterface')
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

        $tracer = new PackshotTracer($dispatcher);
        $tracer->process($packshot);
    }
}