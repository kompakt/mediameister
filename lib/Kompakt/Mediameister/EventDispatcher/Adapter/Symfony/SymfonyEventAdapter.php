<?php

/*
 * This file is part of the kompakt/release-batch-tasks package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher\Adapter\Symfony;

use Kompakt\Mediameister\EventDispatcher\EventInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

class SymfonyEventAdapter extends SymfonyEvent
{
    protected $originalEvent = null;

    public function __construct(EventInterface $originalEvent)
    {
        $this->originalEvent = $originalEvent;
    }

    public function getOriginalEvent()
    {
        return $this->originalEvent;
    }
}