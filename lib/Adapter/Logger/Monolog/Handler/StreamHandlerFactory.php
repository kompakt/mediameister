<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Adapter\Logger\Monolog\Handler;

use Kompakt\Mediameister\Generic\Logger\Handler\StreamHandlerFactoryInterface;
use Kompakt\Mediameister\Generic\Logger\LoggerInterface;
use Monolog\Handler\StreamHandler as MonologStreamhandler;

class StreamHandlerFactory implements StreamHandlerFactoryInterface
{
    public function getInstance($stream, $level = LoggerInterface::DEBUG)
    {
        return new MonologStreamhandler($stream, $level);
    }
}