<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Component\Adapter\Console\Symfony\Output;

use Kompakt\Mediameister\Component\Native\Console\Output\ConsoleOutputInterface as MediameisterConsoleOutputInterface;
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
