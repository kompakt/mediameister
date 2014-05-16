<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Generic\EventDispatcher;

interface EventAdapterInterface
{
    public function getGenericEvent();
    public function isPropagationStopped();
    public function stopPropagation();
}