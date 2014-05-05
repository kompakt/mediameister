<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher;

use Kompakt\Mediameister\EventDispatcher\EventAdapterInterface;

interface EventInterface
{
    public function setAdapter(EventAdapterInterface $adapter);
    public function isPropagationStopped();
    public function stopPropagation($avoidCircularDependency = false);
}