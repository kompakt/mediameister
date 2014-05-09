<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Packshot\Tracer;

use Kompakt\Mediameister\Packshot\Tracer\PackshotTracer;

class PackshotTracerTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $tracer = new PackshotTracer($this->getDispatcher(), $this->getEventNames());
        $tracer->trace($this->getPackshot());
    }

    protected function getDispatcher()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    protected function getEventNames()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Tracer\EventNamesInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    protected function getPackshot()
    {
        $track = $this
            ->getMockBuilder('Kompakt\Mediameister\Entity\TrackInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $release = $this
            ->getMockBuilder('Kompakt\Mediameister\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $release
            ->expects($this->once())
            ->method('getTracks')
            ->will($this->returnValue(array($track)))
        ;

        $packshot = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\PackshotInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $packshot
            ->expects($this->once())
            ->method('getRelease')
            ->will($this->returnValue($release))
        ;

        return $packshot;
    }
}