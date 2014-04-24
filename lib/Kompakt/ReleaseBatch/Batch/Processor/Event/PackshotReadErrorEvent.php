<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Batch\Processor\Event;

use Kompakt\ReleaseBatch\Packshot\PackshotInterface;
use Symfony\Component\EventDispatcher\Event;

class PackshotReadErrorEvent extends Event
{
    protected $packshot = null;
    protected $exception = null;

    public function __construct(PackshotInterface $packshot, \Exception $exception)
    {
        $this->packshot = $packshot;
        $this->exception = $exception;
    }

    public function getPackshot()
    {
        return $this->packshot;
    }

    public function getException()
    {
        return $this->exception;
    }
}