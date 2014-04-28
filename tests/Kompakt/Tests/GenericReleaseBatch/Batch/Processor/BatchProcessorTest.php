<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\GenericReleaseBatch\Batch\Processor;

use Kompakt\GenericReleaseBatch\Batch\Processor\BatchProcessor;

class BatchProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testComplete()
    {
        $processor = new BatchProcessor($this->getDispatcher());
        $processor->process($this->getBatch());
    }

    protected function getBatch()
    {
        $packshot = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\PackshotInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $batch = $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Batch\Batch')
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