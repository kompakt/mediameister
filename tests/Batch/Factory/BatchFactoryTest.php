<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Batch\Factory;

use Kompakt\Mediameister\Batch\Factory\BatchFactory;
use PHPUnit\Framework\TestCase;

class BatchFactoryTest extends TestCase
{
    public function testGetInstance()
    {
        $batchFactory = new BatchFactory($this->getPackshotFactory(), $this->getDirectoryFactory());
        $this->assertInstanceOf('Kompakt\Mediameister\Batch\Batch', $batchFactory->getInstance(__DIR__));
    }

    protected function getPackshotFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Factory\PackshotFactoryInterface')
            ->getMock()
        ;
    }

    protected function getDirectoryFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Util\Filesystem\Factory\DirectoryFactory')
            ->getMock()
        ;
    }
}