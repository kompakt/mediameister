<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Component\Native\EventDispatcher;

use Kompakt\Mediameister\Component\Native\EventDispatcher\EventInterface;
use Kompakt\Mediameister\Component\Native\EventDispatcher\EventSubscriberInterface;

interface EventDispatcherInterface
{
    public function dispatch($eventName, EventInterface $event = null);
    public function addSubscriber(EventSubscriberInterface $subscriber);
}