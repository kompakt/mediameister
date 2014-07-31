<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\SelectionSegregateMover\Exception;

use Kompakt\Mediameister\Exception as BaseException;

class BatchNotFoundException extends \InvalidArgumentException implements BaseException
{}