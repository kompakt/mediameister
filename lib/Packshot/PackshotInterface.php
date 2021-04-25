<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Packshot;

use Kompakt\Mediameister\Entity\ReleaseInterface;

interface PackshotInterface
{
    public function getDir();
    public function getName();
    public function getLayout();
    public function getRelease();
    public function init(ReleaseInterface $release);
    public function load();
}