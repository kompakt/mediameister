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
    public function artwork();
    public function artworkError();
    public function track();
    public function trackError();
    public function metadata();
    public function metadataError();
}