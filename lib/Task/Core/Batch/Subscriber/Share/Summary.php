<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Core\Batch\Subscriber\Share;

use Kompakt\Mediameister\Util\Counter;

class Summary
{
    protected $packshotCounter = null;
    protected $trackCounter = null;

    public function __construct(Counter $counterPrototype)
    {
        $this->packshotCounter = clone $counterPrototype;
        $this->trackCounter = clone $counterPrototype;
    }

    public function getPackshotCounter()
    {
        return $this->packshotCounter;
    }

    public function getTrackCounter()
    {
        return $this->trackCounter;
    }
}