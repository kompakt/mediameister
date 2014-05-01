<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Batch\Tracer\Event;

class Events
{
    const BATCH_START = 'batch_tracer.batch_start';
    const BATCH_ERROR = 'batch_tracer.batch_error';
    const BATCH_END = 'batch_tracer.batch_end';
    const PACKSHOT_READ = 'batch_tracer.packshot_read';
    const PACKSHOT_READ_OK = 'batch_tracer.packshot_read_ok';
    const PACKSHOT_READ_ERROR = 'batch_tracer.packshot_read_error';
}