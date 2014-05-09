<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer;

use Kompakt\Mediameister\Batch\Tracer\EventNamesInterface;

class EventNames implements EventNamesInterface
{
    protected $namespace = null;

    public function __construct($namespace = 'batch_tracer')
    {
        $this->namespace = $namespace;
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
}