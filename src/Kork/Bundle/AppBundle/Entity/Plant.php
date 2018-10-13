<?php

namespace Kork\Bundle\AppBundle\Entity;

class Plant
{
    /** @var string */
    private $id;

    /** @var int */
    private $foodModificator;

    /** @var int */
    private $waterModificator;

    /** @var int */
    private $energyModificator;

    /** @var int */
    private $healthModificator;

    /** @var PlantSpecie */
    private $plantSpecie;

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

    /**
     * @return PlantSpecie
     */
    public function getPlantSpecie(): PlantSpecie
    {
        return $this->plantSpecie;
    }

    /**
     * @param PlantSpecie $plantSpecie
     */
    public function setPlantSpecie(PlantSpecie $plantSpecie): void
    {
        $this->plantSpecie = $plantSpecie;
    }
}
