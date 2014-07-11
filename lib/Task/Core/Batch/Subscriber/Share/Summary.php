<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Core\Batch\Subscriber\Share;

use Kompakt\Mediameister\Util\Counter;

class Summary
{
    protected $packshotCounter = null;
    protected $artworkCounter = null;
    protected $trackCounter = null;
    protected $metadataCounter = null;

    public function __construct(Counter $counterPrototype)
    {
        $this->packshotCounter = clone $counterPrototype;
        $this->artworkCounter = clone $counterPrototype;
        $this->trackCounter = clone $counterPrototype;
        $this->metadataCounter = clone $counterPrototype;
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