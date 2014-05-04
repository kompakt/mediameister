<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\EventDispatcher;

use Kompakt\MediaDeliveryFramework\EventDispatcher\EventInterface;
use Kompakt\MediaDeliveryFramework\EventDispatcher\EventSubscriberInterface;

interface EventDispatcherInterface
{
    public function dispatch($eventName, EventInterface $event = null);
    public function addSubscriber(EventSubscriberInterface $subscriber);
}