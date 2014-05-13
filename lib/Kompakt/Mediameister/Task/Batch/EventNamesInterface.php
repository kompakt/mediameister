<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch;

interface EventNamesInterface
{
    // task events
    public function taskRun();
    public function taskRunError();
    public function taskEnd();
    public function taskEndError();

    // batch events
    public function batchStart();
    public function batchStartError();
    public function packshotLoad();
    public function packshotLoadError();
    public function batchEnd();
    public function batchEndError();

    // packshot events
    public function artwork();
    public function artworkError();
    public function track();
    public function trackError();
    public function metadata();
    public function metadataError();
}