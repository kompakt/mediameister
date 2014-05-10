<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Component\Adapter\Logger\Monolog\Handler;

use Kompakt\Mediameister\Component\Native\Logger\LoggerInterface;
use Kompakt\Mediameister\Component\Native\Logger\Handler\StreamHandlerFactoryInterface;
use Monolog\Handler\StreamHandler as MonologStreamhandler;

class StreamHandlerFactory implements StreamHandlerFactoryInterface
{
    public function getInstance($stream, $level = LoggerInterface::DEBUG)
    {
        return new MonologStreamhandler($stream, $level);
    }
}