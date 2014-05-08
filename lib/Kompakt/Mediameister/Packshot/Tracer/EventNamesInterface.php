<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Tracer;

interface EventNamesInterface
{
    public function intro();
    public function introOk();
    public function introError();
    public function track();
    public function trackOk();
    public function trackError();
    public function outro();
    public function outroOk();
    public function outroError();
}