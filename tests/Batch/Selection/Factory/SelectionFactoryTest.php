<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Batch\Selection\Factory;

use Kompakt\Mediameister\Batch\Selection\Factory\SelectionFactory;

class SelectionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $factory = new SelectionFactory(
            $this->getFileFactory(),
            $this->getDirectoryFactory()
        );

        $this->assertInstanceOf('Kompakt\Mediameister\Batch\Selection\Selection', $factory->getInstance($this->getBatch()));
    }

    protected function getBatch()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Batch\BatchInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    protected function getFileFactory()
    {
        return $this
            ->getMockBuilder('Kompakt\Mediameister\Batch\Selection\Factory\FileFactory')
            ->disableOriginalConstructor()
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