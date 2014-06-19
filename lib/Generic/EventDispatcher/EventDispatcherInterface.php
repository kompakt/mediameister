<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Generic\EventDispatcher;

use Kompakt\Mediameister\Generic\EventDispatcher\EventInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventSubscriberInterface;

interface EventDispatcherInterface
{
    public function dispatch($eventName, EventInterface $event = null);
    public function addSubscriber(EventSubscriberInterface $subscriber);
    public function removeSubscriber(EventSubscriberInterface $subscriber);
    public function addListener($eventName, $listener, $priority = 0);
    public function removeListener($eventName, $listener);
}