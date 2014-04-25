<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\GenericReleaseBatch\Batch\Factory;

use Kompakt\GenericReleaseBatch\Batch\Factory\BatchFactory;

class BatchFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $batchFactory = new BatchFactory($this->getPackshotFactory());
        $this->assertInstanceOf('Kompakt\GenericReleaseBatch\Batch\Batch', $batchFactory->getInstance(__DIR__));
    }

    protected function getPackshotFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\GenericReleaseBatch\Packshot\Factory\PackshotFactoryInterface')
            ->getMock()
        ;
    }
}