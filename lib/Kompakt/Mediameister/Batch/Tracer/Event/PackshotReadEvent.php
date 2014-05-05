<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer\Event;

use Kompakt\Mediameister\Packshot\PackshotInterface;
use Kompakt\Mediameister\EventDispatcher\Event;

class PackshotReadEvent extends Event
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