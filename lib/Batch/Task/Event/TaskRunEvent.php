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

class TaskRunEvent extends Event
{
    protected $batch = null;

    public function __construct(BatchInterface $batch)
    {
        $this->batch = $batch;
    }

    public function getBatch()
    {
        return $this->batch;
    }
}