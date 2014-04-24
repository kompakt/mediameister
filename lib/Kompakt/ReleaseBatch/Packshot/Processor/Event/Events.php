<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Processor\Event;

class Events
{
    const INTRO = 'packshot_processor.intro';
    const INTRO_OK = 'packshot_processor.intro_ok';
    const INTRO_ERROR = 'packshot_processor.intro_error';
    const TRACK = 'packshot_processor.track';
    const TRACK_OK = 'packshot_processor.track_ok';
    const TRACK_ERROR = 'packshot_processor.track_error';
    const OUTRO = 'packshot_processor.outro';
    const OUTRO_OK = 'packshot_processor.outro_ok';
    const OUTRO_ERROR = 'packshot_processor.outro_error';
}