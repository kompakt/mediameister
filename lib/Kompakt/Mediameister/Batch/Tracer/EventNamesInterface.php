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
    public function packshotRead();
    public function packshotReadOk();
    public function packshotReadError();
    public function batchEnd();
    public function batchEndOk();
    public function batchEndError();
}