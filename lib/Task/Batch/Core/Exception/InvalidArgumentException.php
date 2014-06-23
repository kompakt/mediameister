<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Batch\Core\Exception;

use Kompakt\Mediameister\Exception as BaseException;

class InvalidArgumentException extends \InvalidArgumentException implements BaseException
{}