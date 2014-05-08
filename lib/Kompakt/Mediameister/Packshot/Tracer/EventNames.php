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

    public function intro()
    {
        return sprintf('%s.intro', $this->namespace);
    }

    public function introOk()
    {
        return sprintf('%s.intro_ok', $this->namespace);
    }

    public function introError()
    {
        return sprintf('%s.intro_error', $this->namespace);
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

    public function outro()
    {
        return sprintf('%s.outro', $this->namespace);
    }

    public function outroOk()
    {
        return sprintf('%s.outro_ok', $this->namespace);
    }

    public function outroError()
    {
        return sprintf('%s.outro_error', $this->namespace);
    }
}