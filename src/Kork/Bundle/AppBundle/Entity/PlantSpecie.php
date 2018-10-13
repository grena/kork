<?php

namespace Kork\Bundle\AppBundle\Entity;

class PlantSpecie
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
    private $foodMinModificator;

    /** @var int */
    private $foodMaxModificator;

    /** @var int */
    private $waterMinModificator;

    /** @var int */
    private $waterMaxModificator;

    /** @var int */
    private $energyMinModificator;

    /** @var int */
    private $energyMaxModificator;

    /** @var int */
    private $healthMinModificator;

    /** @var int */
    private $healthMaxModificator;

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
    public function getFoodMinModificator(): int
    {
        return $this->foodMinModificator;
    }

    /**
     * @param int $foodMinModificator
     */
    public function setFoodMinModificator(int $foodMinModificator)
    {
        $this->foodMinModificator = $foodMinModificator;
    }

    /**
     * @return int
     */
    public function getFoodMaxModificator(): int
    {
        return $this->foodMaxModificator;
    }

    /**
     * @param int $foodMaxModificator
     */
    public function setFoodMaxModificator(int $foodMaxModificator)
    {
        $this->foodMaxModificator = $foodMaxModificator;
    }

    /**
     * @return int
     */
    public function getWaterMinModificator(): int
    {
        return $this->waterMinModificator;
    }

    /**
     * @param int $waterMinModificator
     */
    public function setWaterMinModificator(int $waterMinModificator)
    {
        $this->waterMinModificator = $waterMinModificator;
    }

    /**
     * @return int
     */
    public function getWaterMaxModificator(): int
    {
        return $this->waterMaxModificator;
    }

    /**
     * @param int $waterMaxModificator
     */
    public function setWaterMaxModificator(int $waterMaxModificator)
    {
        $this->waterMaxModificator = $waterMaxModificator;
    }

    /**
     * @return int
     */
    public function getEnergyMinModificator(): int
    {
        return $this->energyMinModificator;
    }

    /**
     * @param int $energyMinModificator
     */
    public function setEnergyMinModificator(int $energyMinModificator)
    {
        $this->energyMinModificator = $energyMinModificator;
    }

    /**
     * @return int
     */
    public function getEnergyMaxModificator(): int
    {
        return $this->energyMaxModificator;
    }

    /**
     * @param int $energyMaxModificator
     */
    public function setEnergyMaxModificator(int $energyMaxModificator)
    {
        $this->energyMaxModificator = $energyMaxModificator;
    }

    /**
     * @return int
     */
    public function getHealthMinModificator(): int
    {
        return $this->healthMinModificator;
    }

    /**
     * @param int $healthMinModificator
     */
    public function setHealthMinModificator(int $healthMinModificator)
    {
        $this->healthMinModificator = $healthMinModificator;
    }

    /**
     * @return int
     */
    public function getHealthMaxModificator(): int
    {
        return $this->healthMaxModificator;
    }

    /**
     * @param int $healthMaxModificator
     */
    public function setHealthMaxModificator(int $healthMaxModificator)
    {
        $this->healthMaxModificator = $healthMaxModificator;
    }
}
