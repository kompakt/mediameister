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
    public function taskStart();
    public function taskEnd();
    public function taskFinal();
    public function taskError();
}