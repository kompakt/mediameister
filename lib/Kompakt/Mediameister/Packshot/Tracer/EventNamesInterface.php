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
    public function packshotStart();
    public function packshotStartOk();
    public function packshotStartError();
    public function track();
    public function trackOk();
    public function trackError();
    public function packshotEnd();
    public function packshotEndOk();
    public function packshotEndError();
}