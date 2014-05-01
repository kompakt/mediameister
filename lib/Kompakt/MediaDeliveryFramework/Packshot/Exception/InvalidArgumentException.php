<?php

/*
 * This file is part of the kompakt/media-delivery-framwork package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot\Exception;

use Kompakt\MediaDeliveryFramework\Exception as BaseException;

class InvalidArgumentException extends \InvalidArgumentException implements BaseException
{}