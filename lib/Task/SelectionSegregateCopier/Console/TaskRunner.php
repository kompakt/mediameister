<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\SelectionSegregateCopier\Console;

use Kompakt\Mediameister\Task\SelectionSegregateCopier\Task;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

class TaskRunner
{
    protected $task = null;
    protected $output = null;

    public function __construct(
        Task $task,
        ConsoleOutputInterface $output
    )
    {
        $this->task = $task;
        $this->output = $output;
    }

    public function run($batchName)
    {
        try {
            $this->task->segregateCopy($batchName);
        }
        catch (\Exception $e)
        {
            $this->output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }
}