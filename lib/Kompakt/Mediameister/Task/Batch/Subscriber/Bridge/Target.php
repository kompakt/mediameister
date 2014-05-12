<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Subscriber\Bridge;

use Kompakt\Mediameister\Batch\BatchInterface;
use Kompakt\Mediameister\Packshot\PackshotInterface;

class Target
{
    protected $batch = null;
    protected $packshot = null;

    public function setBatch(BatchInterface $batch)
    {
        $this->batch = $batch;
    }

    public function getBatch()
    {
        return $this->batch;
    }

    public function setPackshot(PackshotInterface $packshot)
    {
        $this->packshot = $packshot;
    }

    public function getPackshot()
    {
        return $this->packshot;
    }
}