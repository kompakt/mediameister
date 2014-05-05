<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher;

interface EventAdapterInterface
{
    public function getNativeEvent();
    public function isPropagationStopped();
    public function stopPropagation();
}