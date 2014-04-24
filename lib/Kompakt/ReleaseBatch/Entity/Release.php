<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Entity;

use Kompakt\ReleaseBatch\Entity\Artwork;
use Kompakt\ReleaseBatch\Entity\Track;

class Release
{
    protected $label = null;
    protected $name = null;
    protected $ean = null;
    protected $catalogNumber = null;
    protected $physicalReleaseDate = null;
    protected $digitalReleaseDate = null;
    protected $originalFormat = null;
    protected $shortInfoEn = null;
    protected $shortInfoDe = null;
    protected $infoEn = null;
    protected $infoDe = null;
    protected $saleTerritories = null;
    protected $bundleRestriction = null;
    protected $tracks = array();
    protected $frontArtworkOriginal = null;
    protected $frontArtworkMedium = null;
    protected $frontArtworkSmall = null;

    public function __construct(Artwork $artworkPrototype)
    {
        $this->frontArtworkOriginal = clone $artworkPrototype;
        $this->frontArtworkMedium = clone $artworkPrototype;
        $this->frontArtworkSmall = clone $artworkPrototype;
    }
    
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEan($ean)
    {
        $this->ean = $ean;
        return $this;
    }

    public function getEan()
    {
        return $this->ean;
    }

    public function setCatalogNumber($catalogNumber)
    {
        $this->catalogNumber = $catalogNumber;
        return $this;
    }

    public function getCatalogNumber()
    {
        return $this->catalogNumber;
    }

    public function setPhysicalReleaseDate(\DateTime $physicalReleaseDate)
    {
        $this->physicalReleaseDate = $physicalReleaseDate;
        return $this;
    }

    public function getPhysicalReleaseDate()
    {
        return $this->physicalReleaseDate;
    }

    public function setDigitalReleaseDate(\DateTime $digitalReleaseDate)
    {
        $this->digitalReleaseDate = $digitalReleaseDate;
        return $this;
    }

    public function getDigitalReleaseDate()
    {
        return $this->digitalReleaseDate;
    }

    public function setOriginalFormat($originalFormat)
    {
        $this->originalFormat = $originalFormat;
        return $this;
    }

    public function getOriginalFormat()
    {
        return $this->originalFormat;
    }

    public function setShortInfoEn($shortInfoEn)
    {
        $this->shortInfoEn = $shortInfoEn;
        return $this;
    }

    public function getShortInfoEn()
    {
        return $this->shortInfoEn;
    }

    public function setShortInfoDe($shortInfoDe)
    {
        $this->shortInfoDe = $shortInfoDe;
        return $this;
    }

    public function getShortInfoDe()
    {
        return $this->shortInfoDe;
    }

    public function setInfoEn($infoEn)
    {
        $this->infoEn = $infoEn;
        return $this;
    }

    public function getInfoEn()
    {
        return $this->infoEn;
    }

    public function setInfoDe($infoDe)
    {
        $this->infoDe = $infoDe;
        return $this;
    }

    public function getInfoDe()
    {
        return $this->infoDe;
    }

    public function setSaleTerritories($saleTerritories)
    {
        $this->saleTerritories = $saleTerritories;
        return $this;
    }

    public function getSaleTerritories()
    {
        return $this->saleTerritories;
    }

    public function setBundleRestriction($bundleRestriction)
    {
        $this->bundleRestriction = $bundleRestriction;
        return $this;
    }

    public function getBundleRestriction()
    {
        return $this->bundleRestriction;
    }

    public function addTrack(Track $track)
    {
        $this->tracks[] = $track;
        return $this;
    }

    public function getTracks()
    {
        return $this->tracks;
    }

    public function setFrontArtworkOriginal(Artwork $frontArtworkOriginal)
    {
        $this->frontArtworkOriginal = $frontArtworkOriginal;
        return $this;
    }

    public function getFrontArtworkOriginal()
    {
        return $this->frontArtworkOriginal;
    }

    public function setFrontArtworkMedium(Artwork $frontArtworkMedium)
    {
        $this->frontArtworkMedium = $frontArtworkMedium;
        return $this;
    }

    public function getFrontArtworkMedium()
    {
        return $this->frontArtworkMedium;
    }

    public function setFrontArtworkSmall(Artwork $frontArtworkSmall)
    {
        $this->frontArtworkSmall = $frontArtworkSmall;
        return $this;
    }

    public function getFrontArtworkSmall()
    {
        return $this->frontArtworkSmall;
    }
}