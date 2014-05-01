<?php

/*
 * This file is part of the kompakt/tdd-test package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\MediaDeliveryFramework\DropDir;

use Kompakt\MediaDeliveryFramework\DropDir\DropDir;

class DropDirTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBatches()
    {
        $dropDir = new DropDir($this->getBatchFactory(), $this->getTestDir());
        $this->assertCount(4, $dropDir->getBatches());
    }

    /**
     * @expectedException Kompakt\MediaDeliveryFramework\DropDir\Exception\InvalidArgumentException
     */
    public function testGetBatchWithInvalidName()
    {
        $dropDir = new DropDir($this->getBatchFactory(), $this->getTestDir());
        $dropDir->getBatch('../some-batch');
    }

    public function testCreateBatch()
    {
        $dir = freshTmpSubDir(__CLASS__);
        $dropDir = new DropDir($this->getBatchFactory(), $dir);
        $this->assertCount(0, $dropDir->getBatches());

        $dropDir->createBatch('my-new-batch');
        $this->assertCount(1, $dropDir->getBatches());
    }

    protected function getBatchFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\MediaDeliveryFramework\Batch\Factory\BatchFactoryInterface')
            ->getMock()
        ;
    }

    protected function getTestDir()
    {
        return sprintf('%s/_files/DropDirTest', __DIR__);
    }
}