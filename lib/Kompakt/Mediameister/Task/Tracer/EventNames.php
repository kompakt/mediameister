<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Tracer;

use Kompakt\Mediameister\Task\Tracer\EventNamesInterface;

class EventNames implements EventNamesInterface
{
    protected $namespace = null;

    public function __construct($namespace = 'task_tracer')
    {
        $this->namespace = $namespace;
    }

    public function inputError()
    {
        return sprintf('%s.input_error', $this->namespace);
    }

    public function taskRun()
    {
        return sprintf('%s.task_run', $this->namespace);
    }

    public function taskError()
    {
        return sprintf('%s.task_error', $this->namespace);
    }

    public function taskEnd()
    {
        return sprintf('%s.task_end', $this->namespace);
    }

    public function taskFinal()
    {
        return sprintf('%s.task_final', $this->namespace);
    }
}