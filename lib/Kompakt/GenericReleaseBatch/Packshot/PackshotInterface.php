<?php

/*
 * This file is part of the kompakt/generic-release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\GenericReleaseBatch\Packshot;

use Kompakt\GenericReleaseBatch\Entity\ReleaseInterface;

interface PackshotInterface
{
    public function getName();
    public function getLayout();
    public function getRelease();
    public function getArtworkLoader();
    public function getAudioLoader();
    public function init(ReleaseInterface $release);
    public function load();
}