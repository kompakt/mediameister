<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Core\Subscriber;

use Kompakt\Mediameister\Generic\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Task\Batch\Core\EventNamesInterface;
use Kompakt\Mediameister\Task\Batch\Core\Event\ArtworkErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\ArtworkEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\MetadataErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\MetadataEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\PackshotLoadErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\PackshotLoadEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\TrackErrorEvent;
use Kompakt\Mediameister\Task\Batch\Core\Event\TrackEvent;
use Kompakt\Mediameister\Task\Batch\Core\Subscriber\Share\Summary;

class SummaryMaker implements EventSubscriberInterface
{
    const COUNTER_OK = 'ok';
    const COUNTER_ERROR = 'error';

    protected $eventNames = null;
    protected $summary = null;
    protected $currentPackshot = null;

    public function __construct(
        EventNamesInterface $eventNames,
        Summary $summary
    )
    {
        $this->eventNames = $eventNames;
        $this->summary = $summary;
    }

    public function getSubscriptions()
    {
        return array(
            // batch events
            $this->eventNames->packshotLoad() => array(
                array('onPackshotLoad', 0)
            ),
            $this->eventNames->packshotLoadError() => array(
                array('onPackshotLoadError', 0)
            ),
            // packshot events
            $this->eventNames->artwork() => array(
                array('onArtwork', 0)
            ),
            $this->eventNames->artworkError() => array(
                array('onArtworkError', 0)
            ),
            $this->eventNames->track() => array(
                array('onTrack', 0)
            ),
            $this->eventNames->trackError() => array(
                array('onTrackError', 0)
            ),
            $this->eventNames->metadata() => array(
                array('onMetadata', 0)
            ),
            $this->eventNames->metadataError() => array(
                array('onMetadataError', 0)
            )
        );
    }

    public function onPackshotLoad(PackshotLoadEvent $event)
    {
        $this->currentPackshot = $event->getPackshot();
        $id = $this->currentPackshot->getName();
        $this->summary->getPackshotCounter()->add(self::COUNTER_OK, $id);
    }

    public function onPackshotLoadError(PackshotLoadErrorEvent $event)
    {
        $id = $event->getPackshot()->getName();
        $this->summary->getPackshotCounter()->add(self::COUNTER_ERROR, $id);
    }

    public function onArtwork(ArtworkEvent $event)
    {
        $id = $this->currentPackshot->getName();
        $this->summary->getArtworkCounter()->add(self::COUNTER_OK, $id);
    }

    public function onArtworkError(ArtworkErrorEvent $event)
    {
        $id = $this->currentPackshot->getName();
        $this->summary->getArtworkCounter()->add(self::COUNTER_ERROR, $id);
    }

    public function onTrack(TrackEvent $event)
    {
        $id = $this->currentPackshot->getName() . spl_object_hash($event->getTrack());
        $this->summary->getTrackCounter()->add(self::COUNTER_OK, $id);
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        $id = $this->currentPackshot->getName() . spl_object_hash($event->getTrack());
        $this->summary->getTrackCounter()->add(self::COUNTER_ERROR, $id);
    }

    public function onMetadata(MetadataEvent $event)
    {
        $id = $this->currentPackshot->getName();
        $this->summary->getMetadataCounter()->add(self::COUNTER_OK, $id);
    }

    public function onMetadataError(MetadataErrorEvent $event)
    {
        $id = $this->currentPackshot->getName();
        $this->summary->getMetadataCounter()->add(self::COUNTER_ERROR, $id);
    }
}