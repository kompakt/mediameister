<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot\Metadata\Loader\Exception;

use Kompakt\ReleaseBatch\Exception as BaseException;

class InvalidArgumentException extends \InvalidArgumentException implements BaseException
{}