<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\MediaDeliveryFramework\Packshot\Tracer;

use Kompakt\MediaDeliveryFramework\Packshot\Tracer\PackshotTracer;

class PackshotTracerTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $tracer = new PackshotTracer($this->getDispatcher());
        $tracer->trace($this->getPackshot());
    }

    protected function getDispatcher()
    {
        return $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\EventDispatcher\EventDispatcherInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    protected function getPackshot()
    {
        $track = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Entity\TrackInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $release = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $release
            ->expects($this->once())
            ->method('getTracks')
            ->will($this->returnValue(array($track)))
        ;

        $packshot = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\PackshotInterface')
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