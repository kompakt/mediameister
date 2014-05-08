<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher\Adapter;

interface EventAdapterInterface
{
    public function getOriginalEvent();
    public function isPropagationStopped();
    public function stopPropagation();
}