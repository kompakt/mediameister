<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Util;

class Counter
{
    protected $oks = 0;
    protected $errors = 0;

    public function addOks($count)
    {
        $this->oks += (int) $count;
        return $this;
    }

    public function getOks()
    {
        return $this->oks;
    }

    public function addErrors($count)
    {
        $this->errors += (int) $count;
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getCount()
    {
        return $this->oks + $this->errors;
    }
}