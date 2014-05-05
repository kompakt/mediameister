<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Timer\Exception;

use Kompakt\Mediameister\Exception as BaseException;

class DomainException extends \DomainException implements BaseException
{}