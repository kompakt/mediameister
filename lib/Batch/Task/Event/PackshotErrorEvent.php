<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Event;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;
use Symfony\Contracts\EventDispatcher\Event;

class PackshotErrorEvent extends Event
{
    protected $exception = null;
    protected $batch = null;
    protected $packshot = null;

    public function __construct(\Exception $exception, BatchInterface $batch, PackshotInterface $packshot)
    {
        $this->exception = $exception;
        $this->batch = $batch;
        $this->packshot = $packshot;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function getBatch()
    {
        return $this->batch;
    }

    public function getPackshot()
    {
        return $this->packshot;
    }
}