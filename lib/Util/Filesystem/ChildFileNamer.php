<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Util\Filesystem;

use Kompakt\Mediameister\Util\Filesystem\Exception\InvalidArgumentException;

class ChildFileNamer
{
    protected $dir = null;

    public function __construct($dir)
    {
        $info = new \SplFileInfo($dir);

        if (!$info->isDir())
        {
            throw new InvalidArgumentException(sprintf('Dir not found'));
        }

        if (!$info->isReadable())
        {
            throw new InvalidArgumentException(sprintf('Dir not readable'));
        }

        if (!$info->isWritable())
        {
            throw new InvalidArgumentException(sprintf('Dir not writable'));
        }

        $this->dir = $dir;
    }

    public function make($prefix = '', $postfix = '', $suffix = '')
    {
        $name = $this->assemble($prefix, $postfix, $suffix, null);
        $count = 1;

        while (true)
        {
            $fileInfo = new \SplFileInfo(sprintf('%s/%s', $this->dir, $name));

            if (!$fileInfo->isDir() && !$fileInfo->isFile())
            {
                return basename($name);
            }

            $name = $this->assemble($prefix, $postfix, $suffix, $count++);
        }
    }

    protected function assemble($prefix, $postfix, $suffix, $count)
    {
        if ($prefix != '')
        {
            if ($postfix != '')
            {
                return ($count !== null)
                    ? sprintf('%s-%d-%s%s', $prefix, $count, $postfix, $suffix)
                    : sprintf('%s-%s%s', $prefix, $postfix, $suffix)
                ;
            }

            return ($count !== null)
                ? sprintf('%s-%d%s', $prefix, $count, $suffix)
                : sprintf('%s%s', $prefix, $suffix)
            ;
        }

        return ($count !== null)
            ? sprintf('%d-%s%s', $count, $postfix, $suffix)
            : sprintf('%s%s', $postfix, $suffix)
        ;
    }
}