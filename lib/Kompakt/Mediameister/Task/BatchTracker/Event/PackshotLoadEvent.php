<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\BatchTracker\Event;

use Kompakt\Mediameister\Packshot\PackshotInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\Event;

class PackshotLoadEvent extends Event
{
    protected $packshot = null;

    public function __construct(PackshotInterface $packshot)
    {
        $this->packshot = $packshot;
    }

    public function getPackshot()
    {
        return $this->packshot;
    }
}