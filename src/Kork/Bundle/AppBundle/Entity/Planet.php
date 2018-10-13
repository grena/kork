<?php

namespace Kork\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Planet
{
    /** @var ArrayCollection */
    private $vegetals;

    /** @var ArrayCollection */
    private $availableActions;

    /** @var string */
    private $seed;

    /**
     * @return ArrayCollection
     */
    public function getVegetals(): ArrayCollection
    {
        return $this->vegetals;
    }

    /**
     * @param ArrayCollection $vegetals
     */
    public function setVegetals(ArrayCollection $vegetals): void
    {
        $this->vegetals = $vegetals;
    }

    /**
     * @return ArrayCollection
     */
    public function getAvailableActions(): ArrayCollection
    {
        return $this->availableActions;
    }

    /**
     * @param ArrayCollection $availableActions
     */
    public function setAvailableActions(ArrayCollection $availableActions)
    {
        $this->availableActions = $availableActions;
    }
}
