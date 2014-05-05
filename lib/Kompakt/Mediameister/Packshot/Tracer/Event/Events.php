<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot\Tracer\Event;

class Events
{
    const INTRO = 'packshot_tracer.intro';
    const INTRO_OK = 'packshot_tracer.intro_ok';
    const INTRO_ERROR = 'packshot_tracer.intro_error';
    const TRACK = 'packshot_tracer.track';
    const TRACK_OK = 'packshot_tracer.track_ok';
    const TRACK_ERROR = 'packshot_tracer.track_error';
    const OUTRO = 'packshot_tracer.outro';
    const OUTRO_OK = 'packshot_tracer.outro_ok';
    const OUTRO_ERROR = 'packshot_tracer.outro_error';
}