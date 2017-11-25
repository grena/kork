<?php

namespace Kork\Bundle\AppBundle\Entity;

class Vegetal
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $picture;

    /** @var int */
    private $foodModificator;

    /** @var int */
    private $waterModificator;

    /** @var int */
    private $energyModificator;

    /** @var int */
    private $healthModificator;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string|null $picture
     */
    public function setPicture(?string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return int
     */
    public function getFoodModificator(): int
    {
        return $this->foodModificator;
    }

    /**
     * @param int $foodModificator
     */
    public function setFoodModificator(int $foodModificator)
    {
        $this->foodModificator = $foodModificator;
    }

    /**
     * @return int
     */
    public function getWaterModificator(): int
    {
        return $this->waterModificator;
    }

    /**
     * @param int $waterModificator
     */
    public function setWaterModificator(int $waterModificator)
    {
        $this->waterModificator = $waterModificator;
    }

    /**
     * @return int
     */
    public function getEnergyModificator(): int
    {
        return $this->energyModificator;
    }

    /**
     * @param int $energyModificator
     */
    public function setEnergyModificator(int $energyModificator)
    {
        $this->energyModificator = $energyModificator;
    }

    /**
     * @return int
     */
    public function getHealthModificator(): int
    {
        return $this->healthModificator;
    }

    /**
     * @param int $healthModificator
     */
    public function setHealthModificator(int $healthModificator)
    {
        $this->healthModificator = $healthModificator;
    }
}
