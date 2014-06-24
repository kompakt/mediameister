<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Selection\Copier\Console\Runner;

use Kompakt\Mediameister\Generic\Console\Output\ConsoleOutputInterface;
use Kompakt\Mediameister\Task\Selection\Copier\Manager\TaskManager;

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

    public function run($batchName)
    {
        try {
            $this->taskManager->copy($batchName);
        }
        catch (\Exception $e)
        {
            $this->output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }
}