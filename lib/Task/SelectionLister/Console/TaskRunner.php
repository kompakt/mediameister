<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\SelectionLister\Console;

use Kompakt\Mediameister\Batch\Selection\Factory\SelectionFactory;
use Kompakt\Mediameister\DropDir\DropDir;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

class TaskRunner
{
    protected $selectionFactory = null;
    protected $dropDir = null;
    protected $output = null;

    public function __construct(
        SelectionFactory $selectionFactory,
        DropDir $dropDir,
        ConsoleOutputInterface $output
    )
    {
        $this->selectionFactory = $selectionFactory;
        $this->dropDir = $dropDir;
        $this->output = $output;
    }

    public function run($batchName)
    {
        $batch = $this->dropDir->getBatch($batchName);

        if (!$batch)
        {
            $this->output->writeln(sprintf('<error>Batch does not exist: "%s"</error>', $batchName));
        }

        $selection = $this->selectionFactory->getInstance($batch);

        foreach ($selection->getPackshots() as $packshot)
        {
            $this->output->writeln(sprintf('<info>%s</info>', $packshot->getName()));
        }
    }
}