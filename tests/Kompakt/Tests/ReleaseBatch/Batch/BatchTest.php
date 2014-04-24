<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\ReleaseBatch\Batch;

use Kompakt\ReleaseBatch\Batch\Batch;

class BatchTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPackshots()
    {
        $batch = new Batch($this->getPackshotFactory(), $this->getTestDir());
        $this->assertCount(4, $batch->getPackshots());
    }

    /**
     * @expectedException Kompakt\ReleaseBatch\Batch\Exception\InvalidArgumentException
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

        $batch->createPackshot('my-new-packshot');
        $this->assertCount(1, $batch->getPackshots());
    }

    protected function getPackshotFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\ReleaseBatch\Packshot\Factory\PackshotFactoryInterface')
            ->getMock()
        ;
    }

    protected function getTestDir()
    {
        return sprintf('%s/_files/BatchTest', __DIR__);
    }
}