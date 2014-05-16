<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Adapter\Logger\Monolog;

use Kompakt\Mediameister\Generic\Logger\LoggerInterface;
use Monolog\Logger as MonologLogger;

class Logger implements LoggerInterface
{
    protected $monologLogger = null;

    public function __construct(MonologLogger $monologLogger)
    {
        $this->monologLogger = $monologLogger;
    }

    public function pushHandler($handler)
    {
        $this->monologLogger->pushHandler($handler);
    }

    public function popHandler()
    {
        $this->monologLogger->popHandler();
    }

    public function debug($message, array $context = array())
    {
        $this->monologLogger->debug($message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->monologLogger->info($message, $context);
    }

    public function notice($message, array $context = array())
    {
        $this->monologLogger->notice($message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->monologLogger->warning($message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->monologLogger->error($message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->monologLogger->critical($message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->monologLogger->alert($message, $context);
    }

    public function emergency($message, array $context = array())
    {
        $this->monologLogger->emergency($message, $context);
    }
}