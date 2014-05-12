<?php

/*
 * This file is part of the kompakt/mediameister.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Subscriber\Bridge;

use Kompakt\Mediameister\Util\Counter;

class Summary
{
    protected $packshotCounter = null;
    protected $artworkCounter = null;
    protected $trackCounter = null;
    protected $metadataCounter = null;

    public function __construct()
    {
        $this->packshotCounter = new Counter();
        $this->artworkCounter = new Counter();
        $this->trackCounter = new Counter();
        $this->metadataCounter = new Counter();
    }

    public function getPackshotCounter()
    {
        return $this->packshotCounter;
    }

    public function getArtworkCounter()
    {
        return $this->artworkCounter;
    }

    public function getTrackCounter()
    {
        return $this->trackCounter;
    }

    public function getMetadataCounter()
    {
        return $this->metadataCounter;
    }
}