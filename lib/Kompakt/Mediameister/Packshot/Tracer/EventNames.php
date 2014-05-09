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

    public function artwork()
    {
        return sprintf('%s.artwork', $this->namespace);
    }

    /*public function artworkOk()
    {
        return sprintf('%s.artwork_ok', $this->namespace);
    }*/

    public function artworkError()
    {
        return sprintf('%s.artwork_error', $this->namespace);
    }

    public function track()
    {
        return sprintf('%s.track', $this->namespace);
    }

    /*public function trackOk()
    {
        return sprintf('%s.track_ok', $this->namespace);
    }*/

    public function trackError()
    {
        return sprintf('%s.track_error', $this->namespace);
    }

    public function metadata()
    {
        return sprintf('%s.metadata', $this->namespace);
    }

    /*public function metadataOk()
    {
        return sprintf('%s.metadata_ok', $this->namespace);
    }*/

    public function metadataError()
    {
        return sprintf('%s.metadata_error', $this->namespace);
    }
}