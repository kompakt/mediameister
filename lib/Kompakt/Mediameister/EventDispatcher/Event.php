<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher;

use Kompakt\Mediameister\EventDispatcher\EventAdapterInterface;
use Kompakt\Mediameister\EventDispatcher\EventInterface;

class Event implements EventInterface
{
    protected $adapter = null;
    protected $propagationStopped = false;

    public function setAdapter(EventAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    public function stopPropagation($avoidCircularDependency = false)
    {
        $this->propagationStopped = true;

        if (!$avoidCircularDependency)
        {
            $this->adapter->stopPropagation();
        }
    }
}