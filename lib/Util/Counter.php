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
    protected $oks = array();
    protected $errors = array();

    public function ok($id)
    {
        if (!array_key_exists($id, $this->oks) && !array_key_exists($id, $this->errors))
        {
            $this->oks[$id] = 1;
        }

        return $this;
    }

    public function error($id)
    {
        if (array_key_exists($id, $this->oks))
        {
            // this has already been ok'd but it's an error now
            unset($this->oks[$id]);
        }
        
        if (!array_key_exists($id, $this->errors))
        {
            $this->errors[$id] = 1;
        }

        return $this;
    }

    public function getOks()
    {
        return count($this->oks);
    }

    public function getErrors()
    {
        return count($this->errors);
    }

    public function getTotal()
    {
        return count($this->oks) + count($this->errors);
    }
}