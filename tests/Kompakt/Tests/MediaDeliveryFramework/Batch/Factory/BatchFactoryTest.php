<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\MediaDeliveryFramework\Batch\Factory;

use Kompakt\MediaDeliveryFramework\Batch\Factory\BatchFactory;

class BatchFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $batchFactory = new BatchFactory($this->getPackshotFactory());
        $this->assertInstanceOf('Kompakt\MediaDeliveryFramework\Batch\Batch', $batchFactory->getInstance(__DIR__));
    }

    protected function getPackshotFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Factory\PackshotFactoryInterface')
            ->getMock()
        ;
    }
}