<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\SelectionAdder\Exception;

use Kompakt\Mediameister\Exception as BaseException;

class PackshotNotFoundException extends \InvalidArgumentException implements BaseException
{
    protected $packshotName = null;

    public function setPackshotName($packshotName)
    {
        $this->packshotName = $packshotName;
    }

    public function getPackshotName()
    {
        return $this->packshotName;
    }
}