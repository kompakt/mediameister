<?php

/*
 * This file is part of the kompakt/media-delivery-framework package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\MediaDeliveryFramework\Packshot;

use Kompakt\MediaDeliveryFramework\Entity\ReleaseInterface;

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