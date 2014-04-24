<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\ReleaseBatch\Batch\Processor;

use Kompakt\ReleaseBatch\Batch\Processor\BatchProcessor;

class BatchProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $batch = $this->getBatch();
        $dispatcher = $this->getDispatcher();

        $processor = new BatchProcessor($dispatcher, $batch);
        $processor->process();
    }

    protected function getBatch()
    {
        $packshot = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\PackshotInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $batch = $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Batch\Batch')
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