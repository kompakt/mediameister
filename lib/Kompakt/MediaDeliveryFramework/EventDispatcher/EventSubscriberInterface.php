<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\EventDispatcher;

interface EventSubscriberInterface
{
    public static function getSubscribedEvents();
}