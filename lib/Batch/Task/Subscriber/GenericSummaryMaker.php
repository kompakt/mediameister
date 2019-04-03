<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Task\Subscriber;

use Kompakt\Mediameister\Batch\Task\EventNamesInterface;
use Kompakt\Mediameister\Batch\Task\Event\PackshotErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\PackshotEvent;
use Kompakt\Mediameister\Batch\Task\Event\TrackErrorEvent;
use Kompakt\Mediameister\Batch\Task\Event\TrackEvent;
use Kompakt\Mediameister\Batch\Task\Subscriber\Share\Summary;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GenericSummaryMaker
{
    const OK = 'ok';
    const ERROR = 'error';

    protected $dispatcher = null;
    protected $eventNames = null;
    protected $summary = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames,
        Summary $summary
    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
        $this->summary = $summary;
    }

    public function activate()
    {
        $this->handleListeners(true);
    }

    public function deactivate()
    {
        $this->handleListeners(false);
    }

    protected function handleListeners($add)
    {
        $method = ($add) ? 'addListener' : 'removeListener';

        $this->dispatcher->$method(
            $this->eventNames->packshotLoad(),
            [$this, 'onPackshotLoad']
        );

        $this->dispatcher->$method(
            $this->eventNames->packshotLoadError(),
            [$this, 'onPackshotLoadError']
        );

        $this->dispatcher->$method(
            $this->eventNames->track(),
            [$this, 'onTrack']
        );

        $this->dispatcher->$method(
            $this->eventNames->trackError(),
            [$this, 'onTrackError']
        );
    }

    public function onPackshotLoad(PackshotEvent $event)
    {
        $id = $event->getPackshot()->getName();
        $this->summary->getPackshotCounter()->add(self::OK, $id);
    }

    public function onPackshotLoadError(PackshotErrorEvent $event)
    {
        $id = $event->getPackshot()->getName();
        $this->summary->getPackshotCounter()->add(self::ERROR, $id);
    }

    public function onTrack(TrackEvent $event)
    {
        $id = $event->getPackshot()->getName() . spl_object_hash($event->getTrack());
        $this->summary->getTrackCounter()->add(self::OK, $id);
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        $id = $event->getPackshot()->getName() . spl_object_hash($event->getTrack());
        $this->summary->getTrackCounter()->add(self::ERROR, $id);
    }
}