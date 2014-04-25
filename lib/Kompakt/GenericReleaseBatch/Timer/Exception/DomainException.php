<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Timer\Exception;

use Kompakt\GenericReleaseBatch\Exception as BaseException;

class DomainException extends \DomainException implements BaseException
{}