<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task;

use Kompakt\Mediameister\Batch\Task\EventNamesInterface;

class EventNames implements EventNamesInterface
{
    protected $namespace = null;

    public function __construct($namespace = 'batch_task')
    {
        $this->namespace = $namespace;
    }

    public function taskRun()
    {
        return sprintf('%s.task_start', $this->namespace);
    }

    public function taskRunError()
    {
        return sprintf('%s.task_start_error', $this->namespace);
    }

    public function taskEnd()
    {
        return sprintf('%s.task_end', $this->namespace);
    }

    public function taskEndError()
    {
        return sprintf('%s.task_end_error', $this->namespace);
    }

    public function packshotLoad()
    {
        return sprintf('%s.packshot_load', $this->namespace);
    }

    public function packshotLoadError()
    {
        return sprintf('%s.packshot_load_error', $this->namespace);
    }

    public function packshotUnload()
    {
        return sprintf('%s.packshot_unload', $this->namespace);
    }

    public function packshotUnloadError()
    {
        return sprintf('%s.packshot_unload_error', $this->namespace);
    }

    public function track()
    {
        return sprintf('%s.track', $this->namespace);
    }

    public function trackError()
    {
        return sprintf('%s.track_error', $this->namespace);
    }
}