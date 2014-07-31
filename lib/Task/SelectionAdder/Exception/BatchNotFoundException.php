<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\SelectionAdder\Exception;

use Kompakt\Mediameister\Exception as BaseException;

class BatchNotFoundException extends \InvalidArgumentException implements BaseException
{
    protected $batchName = null;

    public function setBatchName($batchName)
    {
        $this->batchName = $batchName;
    }

    public function getBatchName()
    {
        return $this->batchName;
    }
}