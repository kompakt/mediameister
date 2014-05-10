<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Component\Adapter\EventDispatcher;

interface EventAdapterInterface
{
    public function getOriginalEvent();
    public function isPropagationStopped();
    public function stopPropagation();
}