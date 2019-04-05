<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\BatchLister\Console;

use Kompakt\Mediameister\DropDir\DropDir;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

class TaskRunner
{
    protected $dropDir = null;
    protected $output = null;

    public function __construct(
        DropDir $dropDir,
        ConsoleOutputInterface $output
    )
    {
        $this->dropDir = $dropDir;
        $this->output = $output;
    }

    public function run()
    {
        foreach ($this->dropDir->getBatches() as $batch)
        {
            $this->output->writeln(sprintf('<info>%s</info>', $batch->getName()));
        }
    }
}