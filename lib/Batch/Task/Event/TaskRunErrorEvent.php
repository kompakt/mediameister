<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Event;

use Kompakt\Mediameister\Batch\BatchInterface;
use Symfony\Contracts\EventDispatcher\Event;

class TaskRunErrorEvent extends Event
{
    protected $exception = null;
    protected $batch = null;

    public function __construct(\Exception $exception, BatchInterface $batch)
    {
        $this->exception = $exception;
        $this->batch = $batch;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function getBatch()
    {
        return $this->batch;
    }
}