<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Batch\Tracer;

interface EventNamesInterface
{
    public function batchStart();
    public function batchStartOk();
    public function batchStartError();
    public function packshotLoad();
    public function packshotLoadOk();
    public function packshotLoadError();
    public function batchEnd();
    public function batchEndOk();
    public function batchEndError();
}