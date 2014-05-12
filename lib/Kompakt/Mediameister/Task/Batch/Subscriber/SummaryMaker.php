<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Subscriber;

use Kompakt\Mediameister\Generic\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Task\Batch\EventNamesInterface;
use Kompakt\Mediameister\Task\Batch\Event\ArtworkErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\ArtworkEvent;
use Kompakt\Mediameister\Task\Batch\Event\MetadataErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\MetadataEvent;
use Kompakt\Mediameister\Task\Batch\Event\PackshotLoadErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\PackshotLoadEvent;
use Kompakt\Mediameister\Task\Batch\Event\TrackErrorEvent;
use Kompakt\Mediameister\Task\Batch\Event\TrackEvent;
use Kompakt\Mediameister\Task\Batch\Subscriber\Bridge\Summary;

class SummaryMaker implements EventSubscriberInterface
{
    protected $eventNames = null;
    protected $summary = null;

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

    protected $currentPackshot = null;

    public function onPackshotLoad(PackshotLoadEvent $event)
    {
        $this->currentPackshot = $event->getPackshot();
        $id = $this->currentPackshot->getName();
        $this->summary->getPackshotCounter()->ok($id);
    }

    public function onPackshotLoadError(PackshotLoadErrorEvent $event)
    {
        $id = $event->getPackshot()->getName();
        $this->summary->getPackshotCounter()->error($id);
    }

    public function onArtwork(ArtworkEvent $event)
    {
        $id = $this->currentPackshot->getName();
        $this->summary->getArtworkCounter()->ok($id);
    }

    public function onArtworkError(ArtworkErrorEvent $event)
    {
        $id = $this->currentPackshot->getName();
        $this->summary->getArtworkCounter()->error($id);
    }

    public function onTrack(TrackEvent $event)
    {
        $id = $this->currentPackshot->getName() . $event->getTrack()->getIsrc();
        $this->summary->getTrackCounter()->ok($id);
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        $id = $this->currentPackshot->getName() . $event->getTrack()->getIsrc();
        $this->summary->getTrackCounter()->error($id);
    }

    public function onMetadata(MetadataEvent $event)
    {
        $id = $this->currentPackshot->getName();
        $this->summary->getMetadataCounter()->ok($id);
    }

    public function onMetadataError(MetadataErrorEvent $event)
    {
        $id = $this->currentPackshot->getName();
        $this->summary->getMetadataCounter()->error($id);
    }
}