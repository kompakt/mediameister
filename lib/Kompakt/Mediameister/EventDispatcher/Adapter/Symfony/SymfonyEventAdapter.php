<?php

/*
 * This file is part of the kompakt/release-batch-tasks package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher\Adapter\Symfony;

use Kompakt\Mediameister\EventDispatcher\EventAdapterInterface;
use Kompakt\Mediameister\EventDispatcher\EventInterface;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

class SymfonyEventAdapter extends SymfonyEvent implements EventAdapterInterface
{
    protected $nativeEvent = null;
    protected $propagationStopped = false;

    public function __construct(EventInterface $nativeEvent)
    {
        $this->nativeEvent = $nativeEvent->setAdapter($this);
    }

    public function getNativeEvent()
    {
        return $this->nativeEvent;
    }

    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    public function stopPropagation()
    {
        $this->propagationStopped = true;
        $this->nativeEvent->stopPropagation(true);
    }
}