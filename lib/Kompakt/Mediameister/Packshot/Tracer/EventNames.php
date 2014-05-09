<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Tracer;

use Kompakt\Mediameister\Packshot\Tracer\EventNamesInterface;

class EventNames implements EventNamesInterface
{
    protected $namespace = null;

    public function __construct($namespace = 'packshot_tracer')
    {
        $this->namespace = $namespace;
    }

    public function packshotStart()
    {
        return sprintf('%s.packshot_start', $this->namespace);
    }

    public function packshotStartOk()
    {
        return sprintf('%s.packshot_start_ok', $this->namespace);
    }

    public function packshotStartError()
    {
        return sprintf('%s.packshot_start_error', $this->namespace);
    }

    public function track()
    {
        return sprintf('%s.track', $this->namespace);
    }

    public function trackOk()
    {
        return sprintf('%s.track_ok', $this->namespace);
    }

    public function trackError()
    {
        return sprintf('%s.track_error', $this->namespace);
    }

    public function packshotEnd()
    {
        return sprintf('%s.packshot_end', $this->namespace);
    }

    public function packshotEndOk()
    {
        return sprintf('%s.packshot_end_ok', $this->namespace);
    }

    public function packshotEndError()
    {
        return sprintf('%s.packshot_end_error', $this->namespace);
    }
}