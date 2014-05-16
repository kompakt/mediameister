<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Util\Timer;

use Kompakt\Mediameister\Util\Timer\Exception\DomainException;

class Timer
{
    protected $start = null;
    protected $end = null;

    public function start()
    {
        if (!$this->start)
        {
            $this->start = microtime();
        }

        return $this;
    }

    public function stop()
    {
        if (!$this->end)
        {
            $this->end = microtime();
        }

        return $this;
    }

    public function getSeconds($round = 4)
    {
        if ($this->start === null)
        {
            throw new DomainException('Call Timer::start() before Timer::getSeconds()');
        }

        if ($this->end === null)
        {
            throw new DomainException('Call Timer::stop() before Timer::getSeconds()');
        }

        $this->stop();
        list($usec, $sec) = explode(' ', $this->start);
        $start = (float) $usec + (float) $sec;
        list($usec, $sec) = explode(' ', $this->end);
        $end = (float) $usec + (float) $sec;
        return round($end - $start, $round);
    }
}