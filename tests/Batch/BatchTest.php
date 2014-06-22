<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Batch;

use Kompakt\Mediameister\Batch\Batch;

class BatchTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPackshots()
    {
        $batch = new Batch(
            $this->getPackshotFactory(),
            $this->getDirectoryFactory(),
            $this->getFilesDir()
        );
        
        $this->assertCount(4, $batch->getPackshots());
    }

    /**
     * @expectedException Kompakt\Mediameister\Batch\Exception\InvalidArgumentException
     */
    public function testGetPackshotWithInvalidName()
    {
        $batch = new Batch($this->getPackshotFactory(), $this->getDirectoryFactory(), $this->getFilesDir());
        $batch->getPackshot('../some-packshot');
    }

    public function testCreatePackshot()
    {
        $dir = $this->getTmpDir(__CLASS__);
        $batch = new Batch($this->getPackshotFactory(), $this->getDirectoryFactory(), $dir);
        $this->assertCount(0, $batch->getPackshots());

        $batch->createPackshot('my-new-packshot', $this->getRelease());
        $this->assertCount(1, $batch->getPackshots());
    }

    protected function getPackshotFactory()
    {
        $packshot = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Packshot')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $factory = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\Factory\PackshotFactoryInterface')
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

    protected function getDirectoryFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Util\Filesystem\Factory\DirectoryFactory')
            ->getMock()
        ;
    }

    protected function getRelease()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Entity\ReleaseInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    protected function getFilesDir()
    {
        return sprintf('%s/_files/BatchTest', __DIR__);
    }

    protected function getTmpDir($class)
    {
        $tmpDir = getTmpDir();
        return $tmpDir->replaceSubDir($tmpDir->prepareSubDirPath($class));
    }
}