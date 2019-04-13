<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Logger\Handler\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class StreamHandlerFactory
{
    public function getInstance($stream, $level = Logger::DEBUG)
    {
        return new StreamHandler($stream, $level);
    }
}