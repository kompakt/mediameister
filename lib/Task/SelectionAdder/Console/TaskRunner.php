<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\SelectionAdder\Console;

use Kompakt\Mediameister\Task\SelectionAdder\Task;
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

    public function run($batchName, array $packshotNames)
    {
        try {
            $this->task->add($batchName, $packshotNames);
        }
        catch (\Exception $e)
        {
            $this->output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }
}