<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Tests\Mediameister\Batch\Selection;

use Kompakt\Mediameister\Batch\Selection\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testGetItems()
    {
        $batchDir = sprintf('%s/_files/FileTest', __DIR__);
        $file = new File('.selection', $batchDir);
        $this->assertCount(5, $file->getItems());
    }

    public function testAddItems()
    {
        $batchDir = $this->getTmpDir(__METHOD__);
        $file = new File('.selection', $batchDir);
        $file->addItems(array('xxx', 'yyy', 'zzz'));
        
        $this->assertEquals(
            array('xxx', 'yyy', 'zzz'),
            $file->getItems()
        );
    }

    public function testAddItem()
    {
        $batchDir = $this->getTmpDir(__METHOD__);
        $file = new File('.selection', $batchDir);
        $file->addItem('xxx');
        $file->addItem('yyy');
        $file->addItem('zzz');

        $this->assertEquals(
            array('xxx', 'yyy', 'zzz'),
            $file->getItems()
        );
    }

    public function testRemoveItem()
    {
        $batchDir = $this->getTmpDir(__METHOD__);
        $file = new File('.selection', $batchDir);
        $file->addItems(array('xxx', 'yyy', 'zzz'));
        $file->removeItem('xxx');
        
        $this->assertEquals(
            array('yyy', 'zzz'),
            $file->getItems()
        );
    }

    public function testRemoveItems()
    {
        $batchDir = $this->getTmpDir(__METHOD__);
        $file = new File('.selection', $batchDir);
        $file->addItems(array('xxx', 'yyy', 'zzz'));
        $file->removeItems(array('xxx', 'yyy'));
        
        $this->assertEquals(
            array('zzz'),
            $file->getItems()
        );
    }

    public function testClear()
    {
        $batchDir = $this->getTmpDir(__METHOD__);
        $filename = '.selection';
        $file = new File($filename, $batchDir);
        $file->addItems(array('xxx', 'yyy', 'zzz'));
        $file->clear();
        
        $this->assertFalse(is_file(sprintf('%s/%s', $batchDir, $filename)));
    }

    protected function getTmpDir($class)
    {
        $tmpDir = getTmpDir();
        return $tmpDir->replaceSubDir($tmpDir->prepareSubDirPath($class));
    }
}