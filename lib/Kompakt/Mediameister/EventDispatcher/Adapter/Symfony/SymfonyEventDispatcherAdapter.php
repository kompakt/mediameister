<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher\Adapter\Symfony;

use Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\EventDispatcher\EventInterface;
use Kompakt\Mediameister\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\EventDispatcher\Adapter\Symfony\SymfonyEventAdapter;
use Kompakt\Mediameister\EventDispatcher\Adapter\Symfony\SymfonyEventSubscriberAdapterGenerator;
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