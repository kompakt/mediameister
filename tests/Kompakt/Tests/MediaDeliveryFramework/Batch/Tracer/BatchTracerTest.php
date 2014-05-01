<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\MediaDeliveryFramework\Batch\Tracer;

use Kompakt\MediaDeliveryFramework\Batch\Tracer\BatchTracer;

class BatchTracerTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $tracer = new BatchTracer($this->getDispatcher());
        $tracer->trace($this->getBatch());
    }

    protected function getBatch()
    {
        $packshot = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\PackshotInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $batch = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Batch\Batch')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $batch
            ->expects($this->once())
            ->method('getPackshots')
            ->will($this->returnValue(array($packshot)))
        ;

        return $batch;
    }

    protected function getDispatcher()
    {
        return $this
            ->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}