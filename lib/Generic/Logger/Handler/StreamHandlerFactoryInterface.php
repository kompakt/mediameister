<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Generic\Logger\Handler;

use Kompakt\Mediameister\Generic\Logger\LoggerInterface;

interface StreamHandlerFactoryInterface
{
    public function getInstance($stream, $level = LoggerInterface::DEBUG);
}