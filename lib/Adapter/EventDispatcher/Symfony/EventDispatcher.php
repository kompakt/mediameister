<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Adapter\EventDispatcher\Symfony;

use Kompakt\Mediameister\Generic\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Adapter\EventDispatcher\Symfony\Event as SymfonyEvent;
use Kompakt\Mediameister\Adapter\EventDispatcher\Symfony\EventSubscriberGenerator as SymfonyEventSubscriberGenerator;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;

class EventDispatcher implements EventDispatcherInterface
{
    protected $symfonyDispatcher = null;

    public function __construct(SymfonyEventDispatcher $symfonyDispatcher)
    {
        $this->symfonyDispatcher = $symfonyDispatcher;
    }

    public function dispatch($eventName, EventInterface $event = null)
    {
        $this->symfonyDispatcher->dispatch($eventName, new SymfonyEvent($event));
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $adapterGenerator = new SymfonyEventSubscriberGenerator();
        $className = sprintf('%s_%s', preg_replace('/\\\/', '_', get_class($subscriber)), uniqid());
        $this->symfonyDispatcher->addSubscriber($adapterGenerator->getAdapter($subscriber, $className));
    }

    public function addListener($eventName, $listener, $priority = 0)
    {
        $symfonyListener = function($event) use ($listener)
        {
            call_user_func($listener, $event->getGenericEvent());
        };

        $this->symfonyDispatcher->addListener($eventName, $symfonyListener, $priority);
    }
}