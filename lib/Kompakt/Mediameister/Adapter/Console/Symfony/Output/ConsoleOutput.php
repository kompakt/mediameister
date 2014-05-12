<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Adapter\Console\Symfony\Output;

use Kompakt\Mediameister\Generic\Console\Output\ConsoleOutputInterface as MediameisterConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface as SymfonyConsoleOutputInterface;

class ConsoleOutput implements MediameisterConsoleOutputInterface
{
    protected $symfonyConsoleOutput = null;

    public function __construct(SymfonyConsoleOutputInterface $symfonyConsoleOutput)
    {
        $this->symfonyConsoleOutput = $symfonyConsoleOutput;
    }

    public function writeln($messages)
    {
        $this->symfonyConsoleOutput->writeln($messages);
    }
}
