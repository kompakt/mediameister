<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Adapter\EventDispatcher\Symfony;

use Kompakt\Mediameister\Generic\EventDispatcher\EventAdapterInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

class Event extends SymfonyEvent implements EventAdapterInterface
{
    protected $genericEvent = null;
    protected $propagationStopped = false;

    public function __construct(EventInterface $genericEvent)
    {
        $this->genericEvent = $genericEvent->setAdapter($this);
    }

    public function getGenericEvent()
    {
        return $this->genericEvent;
    }

    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    public function stopPropagation()
    {
        $this->propagationStopped = true;
        $this->genericEvent->stopPropagation(true);
    }
}