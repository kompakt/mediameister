<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Selection\Segregator\Console\Runner;

use Kompakt\Mediameister\Generic\Console\Output\ConsoleOutputInterface;
use Kompakt\Mediameister\Task\Selection\Segregator\Manager\TaskManager;

class TaskRunner
{
    protected $taskManager = null;
    protected $output = null;

    public function __construct(
        TaskManager $taskManager,
        ConsoleOutputInterface $output
    )
    {
        $this->taskManager = $taskManager;
        $this->output = $output;
    }

    public function copyPackshots($batchName)
    {
        try {
            $this->taskManager->copyPackshots($batchName);
        }
        catch (\Exception $e)
        {
            $this->output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }

    public function movePackshots($batchName)
    {
        try {
            $this->taskManager->movePackshots($batchName);
        }
        catch (\Exception $e)
        {
            $this->output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }
}