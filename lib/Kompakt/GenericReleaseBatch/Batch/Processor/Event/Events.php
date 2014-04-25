<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Batch\Processor\Event;

class Events
{
    const BATCH_START = 'batch_processor.batch_start';
    const BATCH_ERROR = 'batch_processor.batch_error';
    const BATCH_END = 'batch_processor.batch_end';
    const PACKSHOT_READ = 'batch_processor.packshot_read';
    const PACKSHOT_READ_OK = 'batch_processor.packshot_read_ok';
    const PACKSHOT_READ_ERROR = 'batch_processor.packshot_read_error';
}