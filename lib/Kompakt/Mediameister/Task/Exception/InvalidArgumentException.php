<?php

/*
 * This file is part of the kompakt/release-batch-tasks package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Exception;

use Kompakt\Mediameister\Exception as MeisterException;

class InvalidArgumentException extends \InvalidArgumentException implements MeisterException
{}