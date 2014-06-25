<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Deleter\Console\Runner;

use Kompakt\Mediameister\Generic\Console\Output\ConsoleOutputInterface;
use Kompakt\Mediameister\DropDir\DropDir;

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

    public function run($batchName)
    {
        $this->dropDir->deleteBatch($batchName);
    }
}