<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\SelectionAdder;

use Kompakt\Mediameister\Batch\Selection\Factory\SelectionFactory;
use Kompakt\Mediameister\DropDir\DropDir;
use Kompakt\Mediameister\Task\SelectionAdder\Exception\BatchNotFoundException;
use Kompakt\Mediameister\Task\SelectionAdder\Exception\PackshotNotFoundException;

class Task
{
    protected $selectionFactory = null;
    protected $dropDir = null;

    public function __construct(
        SelectionFactory $selectionFactory,
        DropDir $dropDir
    )
    {
        $this->selectionFactory = $selectionFactory;
        $this->dropDir = $dropDir;
    }

    public function add($batchName, array $packshotNames)
    {
        $batch = $this->dropDir->getBatch($batchName);

        if (!$batch)
        {
            $e = new BatchNotFoundException(sprintf('Batch does not exist: "%s"', $batchName));
            $e->setBatchName($batchName);
            throw $e;
        }

        $addedPackshots = array();

        foreach ($packshotNames as $packshotName)
        {
            $packshot = $batch->getPackshot($packshotName);

            if (!$packshot)
            {
                $e = new PackshotNotFoundException(sprintf('Packshot does not exist: "%s"', $packshotName));
                $e->setPackshotName($packshotName);
                throw $e;
            }

            $addedPackshots[] = $packshot;
        }

        $selection = $this->selectionFactory->getInstance($batch);

        foreach ($addedPackshots as $packshot)
        {
            $selection->addPackshot($packshot);
        }

        return $addedPackshots;
    }
}