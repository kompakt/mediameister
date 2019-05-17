<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\SelectionRemover;

use Kompakt\Mediameister\Batch\Selection\Factory\SelectionFactory;
use Kompakt\Mediameister\DropDir\DropDir;
use Kompakt\Mediameister\Task\SelectionRemover\Exception\BatchNotFoundException;

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

    public function remove($batchName, array $packshotNames)
    {
        $batch = $this->dropDir->getBatch($batchName);

        if (!$batch)
        {
            throw new BatchNotFoundException(sprintf('Batch does not exist: "%s"', $batchName));
        }

        $selection = $this->selectionFactory->getInstance($batch);
        $removedPackshotNames = array();

        foreach ($packshotNames as $packshotName)
        {
            $packshot = $batch->getPackshot($packshotName);

            if ($packshot)
            {
                $packshotName = $packshot->getName();
                $selection->removePackshot($packshot);
                $removedPackshotNames[] = $packshotName;
            }
        }

        return $removedPackshotNames;
    }
}