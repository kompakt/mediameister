<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher;

use Kompakt\Mediameister\EventDispatcher\EventInterface;
use Kompakt\Mediameister\EventDispatcher\EventSubscriberInterface;

interface EventDispatcherInterface
{
    public function dispatch($eventName, EventInterface $event = null);
    public function addSubscriber(EventSubscriberInterface $subscriber);
}