<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Packshot;

interface PackshotInterface
{
    public function getName();
    public function getLayout();
    public function getRelease();
    public function getArtworkLoader();
    public function getAudioLoader();
}