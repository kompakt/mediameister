<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\EventDispatcher\Adapter\Symfony;

use Kompakt\Mediameister\EventDispatcher\EventSubscriberInterface;

class SymfonyEventSubscriberAdapterGenerator
{
    public function getAdapter(EventSubscriberInterface $originalSubscriber, $className)
    {
        $events = $originalSubscriber->getSubscriptions();

        $classDefinition = sprintf(
            $this->getClassCode(),
            $className,
            var_export($events, true),
            $this->getMethods($events)
        );

        eval($classDefinition);
        $className = sprintf('\%s', $className);
        return new $className($originalSubscriber);
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
            use Kompakt\Mediameister\EventDispatcher\EventSubscriberInterface;
            use Kompakt\Mediameister\EventDispatcher\Adapter\Symfony\SymfonyEventAdapter;
            use Symfony\Component\EventDispatcher\EventSubscriberInterface as SymfonyEventSubscriberInterface;

            class %s implements SymfonyEventSubscriberInterface
            {
                protected $originalSubscriber = null;

                public function __construct(EventSubscriberInterface $originalSubscriber)
                {
                    $this->originalSubscriber = $originalSubscriber;
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
            public function %s (SymfonyEventAdapter $e)
            {
                // extract the original event and pass it to the subscriber
                $this->originalSubscriber->%s($e->getOriginalEvent());
            }
        ';
    }
}