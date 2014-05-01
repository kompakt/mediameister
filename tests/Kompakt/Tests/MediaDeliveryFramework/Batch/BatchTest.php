<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\MediaDeliveryFramework\Batch;

use Kompakt\MediaDeliveryFramework\Batch\Batch;

class BatchTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPackshots()
    {
        $batch = new Batch($this->getPackshotFactory(), $this->getTestDir());
        $this->assertCount(4, $batch->getPackshots());
    }

    /**
     * @expectedException Kompakt\MediaDeliveryFramework\Batch\Exception\InvalidArgumentException
     */
    public function testGetPackshotWithInvalidName()
    {
        $batch = new Batch($this->getPackshotFactory(), $this->getTestDir());
        $batch->getPackshot('../some-packshot');
    }

    public function testCreatePackshot()
    {
        $dir = freshTmpSubDir(__CLASS__);
        $batch = new Batch($this->getPackshotFactory(), $dir);
        $this->assertCount(0, $batch->getPackshots());

        $batch->createPackshot('my-new-packshot', $this->getRelease());
        $this->assertCount(1, $batch->getPackshots());
    }

    protected function getPackshotFactory()
    {
        $packshot = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Packshot')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Packshot\Factory\PackshotFactoryInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $factory
            ->expects($this->any())
            ->method('getInstance')
            ->will($this->returnValue($packshot))
        ;

        return $factory;
    }

    protected function getRelease()
    {
        return $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    protected function getTestDir()
    {
        return sprintf('%s/_files/BatchTest', __DIR__);
    }
}