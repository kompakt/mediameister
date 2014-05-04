<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Tracer\Event;

use Kompakt\MediaDeliveryFramework\Packshot\PackshotInterface;
use Kompakt\MediaDeliveryFramework\EventDispatcher\EventInterface;

class PackshotReadErrorEvent implements EventInterface
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