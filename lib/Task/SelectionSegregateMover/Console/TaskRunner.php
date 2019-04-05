<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\SelectionSegregateMover\Console;

use Kompakt\Mediameister\Task\SelectionSegregateMover\Task;
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
            $this->task->segregateMove($batchName);
        }
        catch (\Exception $e)
        {
            $this->output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }
}