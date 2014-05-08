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

    public function inputOk()
    {
        return sprintf('%s.input_ok', $this->namespace);
    }

    public function inputError()
    {
        return sprintf('%s.input_error', $this->namespace);
    }

    public function taskEnd()
    {
        return sprintf('%s.task_end', $this->namespace);
    }
}