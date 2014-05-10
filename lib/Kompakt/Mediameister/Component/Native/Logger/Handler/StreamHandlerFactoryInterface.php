<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Component\Native\Logger\Handler;

interface StreamHandlerFactoryInterface
{
    public function getInstance($stream, $level = Logger::DEBUG);
}