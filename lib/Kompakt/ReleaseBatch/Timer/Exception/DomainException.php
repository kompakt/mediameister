<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Timer\Exception;

use Kompakt\ReleaseBatch\Exception as BaseException;

class DomainException extends \DomainException implements BaseException
{}