<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\BatchTracker;

use Kompakt\Mediameister\Task\BatchTracker\EventNamesInterface;

class EventNames implements EventNamesInterface
{
    protected $namespace = null;

    public function __construct($namespace = 'batch_tracker_task')
    {
        $this->namespace = $namespace;
    }

    public function inputError()
    {
        return sprintf('%s.input_error', $this->namespace);
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

    public function taskFinal()
    {
        return sprintf('%s.task_final', $this->namespace);
    }

    public function batchStart()
    {
        return sprintf('%s.batch_start', $this->namespace);
    }

    public function batchStartError()
    {
        return sprintf('%s.batch_start_error', $this->namespace);
    }

    public function packshotLoad()
    {
        return sprintf('%s.packshot_load', $this->namespace);
    }

    public function packshotLoadError()
    {
        return sprintf('%s.packshot_load_error', $this->namespace);
    }

    public function batchEnd()
    {
        return sprintf('%s.batch_end', $this->namespace);
    }

    public function batchEndError()
    {
        return sprintf('%s.batch_end_error', $this->namespace);
    }

    public function artwork()
    {
        return sprintf('%s.artwork', $this->namespace);
    }

    public function artworkError()
    {
        return sprintf('%s.artwork_error', $this->namespace);
    }

    public function track()
    {
        return sprintf('%s.track', $this->namespace);
    }

    public function trackError()
    {
        return sprintf('%s.track_error', $this->namespace);
    }

    public function metadata()
    {
        return sprintf('%s.metadata', $this->namespace);
    }

    public function metadataError()
    {
        return sprintf('%s.metadata_error', $this->namespace);
    }
}