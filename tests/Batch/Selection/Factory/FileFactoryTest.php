<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Batch\Selection\Factory;

use Kompakt\Mediameister\Batch\Selection\Factory\FileFactory;

class FileFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $factory = new FileFactory('.selection');
        $this->assertInstanceOf('Kompakt\Mediameister\Batch\Selection\File', $factory->getInstance(__DIR__));
    }
}