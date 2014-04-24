<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Entity;

class Artwork
{
    protected $name = null;
    protected $mime = null;
    protected $size = null;
    protected $width = null;
    protected $height = null;
    
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

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }
}