<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Timer\Exception;

use Kompakt\MediaDeliveryFramework\Exception as BaseException;

class DomainException extends \DomainException implements BaseException
{}