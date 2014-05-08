<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher\Adapter\Symfony;

use Kompakt\Mediameister\EventDispatcher\Adapter\EventAdapterInterface;
use Kompakt\Mediameister\EventDispatcher\EventInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

class SymfonyEventAdapter extends SymfonyEvent implements EventAdapterInterface
{
    protected $originalEvent = null;
    protected $propagationStopped = false;

    public function __construct(EventInterface $originalEvent)
    {
        $this->originalEvent = $originalEvent->setAdapter($this);
    }

    public function getOriginalEvent()
    {
        return $this->originalEvent;
    }

    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    public function stopPropagation()
    {
        $this->propagationStopped = true;
        $this->originalEvent->stopPropagation(true);
    }
}