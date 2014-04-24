<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Entity;

class Audio
{
    protected $name = null;
    protected $mime = null;
    protected $size = null;
    protected $quality = null;

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setMime($mime)
    {
        $this->mime = $mime;
        return $this;
    }

    public function getMime()
    {
        return $this->mime;
    }

    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setQuality($quality)
    {
        $this->quality = $quality;
        return $this;
    }

    public function getQuality()
    {
        return $this->quality;
    }
}