<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Batch\Selection;

use Kompakt\Mediameister\Batch\Selection\Selection;

class SelectionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPackshots()
    {
        $selection = new Selection(
            $this->getFileFactory(),
            $this->getDirectoryFactory(),
            $this->getBatch()
        );

        $this->assertCount(2, $selection->getPackshots());
    }

    protected function getBatch()
    {
        $batch = $this
            ->getMockBuilder('Kompakt\Mediameister\Batch\BatchInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $packshot = $this
            ->getMockBuilder('Kompakt\Mediameister\Packshot\PackshotInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $batch
            ->expects($this->any())
            ->method('getPackshot')
            ->will($this->returnValue($packshot))
        ;

        return $batch;
    }

    protected function getFileFactory()
    {
        $factory = $this
            ->getMockBuilder('Kompakt\Mediameister\Batch\Selection\Factory\FileFactory')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $file = $this
            ->getMockBuilder('Kompakt\Mediameister\Batch\Selection\File')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $file
            ->expects($this->any())
            ->method('getItems')
            ->will($this->returnValue(array('packshot-1', 'packshot-2')))
        ;

        $factory
            ->expects($this->any())
            ->method('getInstance')
            ->will($this->returnValue($file))
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
}