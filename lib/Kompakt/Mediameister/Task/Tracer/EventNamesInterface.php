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
    public function taskRunError();
    public function taskEnd();
    public function taskEndError();
    public function taskFinal();

    public function batchStart();
    public function batchStartError();
    public function packshotLoad();
    public function packshotLoadError();
    public function batchEnd();
    public function batchEndError();

    public function artwork();
    public function artworkError();
    public function track();
    public function trackError();
    public function metadata();
    public function metadataError();
}