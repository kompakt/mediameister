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

    public function batchStartOk()
    {
        return sprintf('%s.batch_start_ok', $this->namespace);
    }

    public function batchStartError()
    {
        return sprintf('%s.batch_start_error', $this->namespace);
    }

    public function packshotRead()
    {
        return sprintf('%s.packshot_read', $this->namespace);
    }

    public function packshotReadOk()
    {
        return sprintf('%s.packshot_read_ok', $this->namespace);
    }

    public function packshotReadError()
    {
        return sprintf('%s.packshot_read_error', $this->namespace);
    }

    public function batchEnd()
    {
        return sprintf('%s.batch_end', $this->namespace);
    }

    public function batchEndOk()
    {
        return sprintf('%s.batch_end_ok', $this->namespace);
    }

    public function batchEndError()
    {
        return sprintf('%s.batch_end_error', $this->namespace);
    }
}