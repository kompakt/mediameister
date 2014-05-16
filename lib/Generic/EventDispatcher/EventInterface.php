<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Generic\EventDispatcher;

use Kompakt\Mediameister\Generic\EventDispatcher\EventAdapterInterface;

interface EventInterface
{
    public function setAdapter(EventAdapterInterface $adapter);
    public function isPropagationStopped();
    public function stopPropagation($avoidCircularDependency = false);
}