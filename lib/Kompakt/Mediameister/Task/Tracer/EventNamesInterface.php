<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Tracer;

interface EventNamesInterface
{
    public function inputError();
    public function taskRun();
    public function taskError();
    public function taskEnd();
    public function taskFinal();
}