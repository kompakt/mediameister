<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\ReleaseBatch\Batch\Factory;

use Kompakt\ReleaseBatch\Batch\Factory\BatchFactory;

class BatchFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $batchFactory = new BatchFactory($this->getPackshotFactory());
        $this->assertInstanceOf('Kompakt\ReleaseBatch\Batch\Batch', $batchFactory->getInstance(__DIR__));
    }

    protected function getPackshotFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Factory\PackshotFactoryInterface')
            ->getMock()
        ;
    }
}