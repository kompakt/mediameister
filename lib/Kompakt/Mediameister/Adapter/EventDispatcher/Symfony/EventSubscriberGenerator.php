<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Adapter\EventDispatcher\Symfony;

use Kompakt\Mediameister\Generic\EventDispatcher\EventSubscriberInterface;

class EventSubscriberGenerator
{
    public function getAdapter(EventSubscriberInterface $genericSubscriber, $className)
    {
        $events = $genericSubscriber->getSubscriptions();

        $classDefinition = sprintf(
            $this->getClassCode(),
            $className,
            var_export($events, true),
            $this->getMethods($events)
        );

        eval($classDefinition);
        $className = sprintf('\%s', $className);
        return new $className($genericSubscriber);
    }

    protected function getMethods($events)
    {
        $s = '';

        foreach ($events as $name => $info)
        {
            $s .= sprintf($this->getMethodCode(), $info[0][0], $info[0][0]);
        }

        return $s;
    }

    protected function getClassCode()
    {
        return '
            use Kompakt\Mediameister\Adapter\EventDispatcher\Symfony\Event as SymfonyEvent;
            use Kompakt\Mediameister\Generic\EventDispatcher\EventSubscriberInterface;
            use Symfony\Component\EventDispatcher\EventSubscriberInterface as SymfonyEventSubscriberInterface;

            class %s implements SymfonyEventSubscriberInterface
            {
                protected $genericSubscriber = null;

                public function __construct(EventSubscriberInterface $genericSubscriber)
                {
                    $this->genericSubscriber = $genericSubscriber;
                }

                public static function getSubscribedEvents()
                {
                    return %s;
                }

                %s
            };
        ';
    }

    protected function getMethodCode()
    {
        return '
            public function %s (SymfonyEvent $e)
            {
                // extract the original event and pass it to the subscriber
                $this->genericSubscriber->%s($e->getGenericEvent());
            }
        ';
    }
}