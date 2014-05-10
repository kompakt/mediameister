<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Component\Native\Logger;

interface LoggerInterface
{
    const DEBUG = 100;
    const INFO = 200;
    const NOTICE = 250;
    const WARNING = 300;
    const ERROR = 400;
    const CRITICAL = 500;
    const ALERT = 550;
    const EMERGENCY = 600;

    public function pushHandler($handler);
    public function popHandler();
    public function debug($message, array $context = array());
    public function info($message, array $context = array());
    public function notice($message, array $context = array());
    public function warning($message, array $context = array());
    public function error($message, array $context = array());
    public function critical($message, array $context = array());
    public function alert($message, array $context = array());
    public function emergency($message, array $context = array());
}