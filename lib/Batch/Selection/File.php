<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Selection;

use Kompakt\Mediameister\Batch\Selection\Exception\InvalidArgumentException;

class File
{
    protected $file = null;

    public function __construct($filename, $dir)
    {
        $info = new \SplFileInfo($dir);

        if (!$info->isDir())
        {
            throw new InvalidArgumentException(sprintf('Selection file parent dir not found'));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('Selection file parent dir not readable'));
        }

        if (!$info->isWritable())
        {
            throw new InvalidArgumentException(sprintf('Selection file parent dir not writable'));
        }

        $this->file = sprintf('%s/%s', $dir, $filename);
    }

    public function getItems()
    {
        $lines = $this->getLines();
        sort($lines);
        return $lines;
    }

    public function addItem($item)
    {
        $this->addItems(array($item));
    }

    public function addItems(array $items)
    {
        $lines = array_merge($this->getLines(), $items);
        $this->writeLines(array_unique($lines));
    }

    public function removeItem($item)
    {
        $this->removeItems(array($item));
    }

    public function removeItems(array $items)
    {
        $lines = array();

        foreach($this->getLines() as $line)
        {
            if (array_search($line, $items) === false)
            {
                $lines[] = $line;
            }
        }

        $this->writeLines($lines);
    }

    public function clear()
    {
        if ($this->hasFile())
        {
            unlink($this->file);
        }
    }

    protected function hasFile()
    {
        $info = new \SplFileInfo($this->file);
        return $info->isFile();
    }

    protected function writeLines(array $lines)
    {
        $handle = fopen($this->file, 'w+');
        fwrite($handle, implode("\n", $lines));
        fclose($handle);
    }

    protected function getLines()
    {
        clearstatcache(true, $this->file);

        if (!$this->hasFile() || !filesize($this->file))
        {
            return array();
        }

        $handle = fopen($this->file, 'r');
        $data = fread($handle, filesize($this->file));
        fclose($handle);
        return explode("\n", $data);
    }
}