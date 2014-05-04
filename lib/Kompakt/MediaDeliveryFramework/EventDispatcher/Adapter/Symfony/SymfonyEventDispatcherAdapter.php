<?php

/*
 * This file is part of the kompakt/release-batch-tasks package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\EventDispatcher\Adapter\Symfony;

use Kompakt\MediaDeliveryFramework\EventDispatcher\EventDispatcherInterface;
use Kompakt\MediaDeliveryFramework\EventDispatcher\EventInterface;
use Kompakt\MediaDeliveryFramework\EventDispatcher\EventSubscriberInterface;
use Kompakt\MediaDeliveryFramework\EventDispatcher\Adapter\Symfony\SymfonyEventAdapter;
use Kompakt\MediaDeliveryFramework\EventDispatcher\Adapter\Symfony\SymfonyEventSubscriberAdapterGenerator;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;

class SymfonyEventDispatcherAdapter implements EventDispatcherInterface
{
    protected $symfonyDispatcher = null;

    public function __construct(SymfonyEventDispatcher $symfonyDispatcher)
    {
        $this->symfonyDispatcher = $symfonyDispatcher;
    }

    public function dispatch($eventName, EventInterface $event = null)
    {
        $this->symfonyDispatcher->dispatch($eventName, new SymfonyEventAdapter($event));
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $adapterGenerator = new SymfonyEventSubscriberAdapterGenerator();
        $className = sprintf('GeneratedSubscriberAdapter_%s', uniqid());
        $this->symfonyDispatcher->addSubscriber($adapterGenerator->getAdapter($subscriber, $className));
    }
}