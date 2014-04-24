<?php

/*
 * This file is part of the kompakt/release-batch package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\ReleaseBatch\Entity;

use Kompakt\ReleaseBatch\Entity\Audio;

class Track
{
    protected $isrc = null;
    protected $position = null;
    protected $artist = null;
    protected $composer = null;
    protected $songwriter = null;
    protected $publisher = null;
    protected $title = null;
    protected $genre = null;
    protected $media = null;
    protected $discNr = null;
    protected $albumNr = null;
    protected $duration = null;
    protected $wavAudio = null;
    protected $mp3VinylAudio = null;
    protected $mp3ShortAudio = null;
    protected $mp3LoAudio = null;
    protected $mp3HiAudio = null;

    public function __construct(Audio $audioPrototype)
    {
        $this->wavAudio = clone $audioPrototype;
        $this->mp3VinylAudio = clone $audioPrototype;
        $this->mp3ShortAudio = clone $audioPrototype;
        $this->mp3LoAudio = clone $audioPrototype;
        $this->mp3HiAudio = clone $audioPrototype;
    }
    
    public function setIsrc($isrc)
    {
        $this->isrc = $isrc;
        return $this;
    }

    public function getIsrc()
    {
        return $this->isrc;
    }

    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setArtist($artist)
    {
        $this->artist = $artist;
        return $this;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function setComposer($composer)
    {
        $this->composer = $composer;
        return $this;
    }

    public function getComposer()
    {
        return $this->composer;
    }

    public function setSongwriter($songwriter)
    {
        $this->songwriter = $songwriter;
        return $this;
    }

    public function getSongwriter()
    {
        return $this->songwriter;
    }

    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
        return $this;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function setMedia($media)
    {
        $this->media = $media;
        return $this;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function setDiscNr($discNr)
    {
        $this->discNr = $discNr;
        return $this;
    }

    public function getDiscNr()
    {
        return $this->discNr;
    }

    public function setAlbumNr($albumNr)
    {
        $this->albumNr = $albumNr;
        return $this;
    }

    public function getAlbumNr()
    {
        return $this->albumNr;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setWavAudio(Audio $wavAudio)
    {
        $this->wavAudio = $wavAudio;
        return $this;
    }

    public function getWavAudio()
    {
        return $this->wavAudio;
    }

    public function setMp3VinylAudio(Audio $mp3VinylAudio)
    {
        $this->mp3VinylAudio = $mp3VinylAudio;
        return $this;
    }

    public function getMp3VinylAudio()
    {
        return $this->mp3VinylAudio;
    }

    public function setMp3ShortAudio(Audio $mp3ShortAudio)
    {
        $this->mp3ShortAudio = $mp3ShortAudio;
        return $this;
    }

    public function getMp3ShortAudio()
    {
        return $this->mp3ShortAudio;
    }

    public function setMp3LoAudio(Audio $mp3LoAudio)
    {
        $this->mp3LoAudio = $mp3LoAudio;
        return $this;
    }

    public function getMp3LoAudio()
    {
        return $this->mp3LoAudio;
    }

    public function setMp3HiAudio(Audio $mp3HiAudio)
    {
        $this->mp3HiAudio = $mp3HiAudio;
        return $this;
    }

    public function getMp3HiAudio()
    {
        return $this->mp3HiAudio;
    }
}