<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Batch\Tracer;

use Kompakt\Mediameister\Batch\Tracer\BatchTracer;

class BatchTracerTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $tracer = new BatchTracer($this->getDispatcher(), $this->getEventNames());
        $tracer->trace($this->getBatch());
    }

    protected function getEventNames()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Batch\Tracer\EventNamesInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    protected function getBatch()
    {
        $packshot = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\PackshotInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $batch = $this
            ->getMockBuilder('Kompakt\Mediameister\Batch\Batch')
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
            ->getMockBuilder('Kompakt\Mediameister\Component\Native\EventDispatcher\EventDispatcherInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}