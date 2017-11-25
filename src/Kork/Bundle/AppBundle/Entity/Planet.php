<?php

namespace Kork\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Planet
{
    /** @var ArrayCollection */
    private $vegetals;

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
}
