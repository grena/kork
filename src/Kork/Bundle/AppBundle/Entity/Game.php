<?php

namespace Kork\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;

class Game
{
    /** @var string */
    private $id;

    /** @var \DateTime */
    private $date_creation;

    /** @var int */
    private $currentDay;

    /** @var string */
    private $gameSeed;

    /** @var Collection */
    private $characters;

    /** @var Collection */
    private $vegetalReferences;

    /** @var Collection */
    private $planets;

    /** @var Collection */
    private $events;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param \DateTime $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return int
     */
    public function getCurrentDay(): int
    {
        return $this->currentDay;
    }

    /**
     * @param int $currentDay
     */
    public function setCurrentDay(int $currentDay)
    {
        $this->currentDay = $currentDay;
    }

    /**
     * @return Collection
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * @param Collection $events
     */
    public function setEvents(Collection $events)
    {
        $this->events = $events;
    }

    /**
     * @return Collection|null
     */
    public function getCharacters(): ?Collection
    {
        return $this->characters;
    }

    /**
     * @param Collection $characters
     */
    public function setCharacters(Collection $characters)
    {
        $this->characters = $characters;
    }

    /**
     * @return string
     */
    public function getGameSeed(): string
    {
        return $this->gameSeed;
    }

    /**
     * @param string $gameSeed
     */
    public function setGameSeed(string $gameSeed)
    {
        $this->gameSeed = $gameSeed;
    }

    /**
     * @return Collection
     */
    public function getVegetalReferences(): Collection
    {
        return $this->vegetalReferences;
    }

    /**
     * @param Collection $vegetalReferences
     */
    public function setVegetalReferences(Collection $vegetalReferences)
    {
        $this->vegetalReferences = $vegetalReferences;
    }

    /**
     * @return Collection
     */
    public function getPlanets(): Collection
    {
        return $this->planets;
    }

    /**
     * @param Collection $planets
     */
    public function setPlanets(Collection $planets)
    {
        $this->planets = $planets;
    }
}
