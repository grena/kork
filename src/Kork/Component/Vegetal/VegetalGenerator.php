<?php

namespace Kork\Component\Vegetal;


use Kork\Bundle\AppBundle\Entity\Game;
use Kork\Bundle\AppBundle\Entity\Plant;
use Kork\Bundle\AppBundle\Entity\PlantSpecie;

class VegetalGenerator
{
    public function generate(Game $game): Plant
    {
        $randomIndex = rand(1, $game->getVegetalReferences()->count()) - 1;
        /** @var PlantSpecie $vegetalReference */
        $vegetalReference = $game->getVegetalReferences()->offsetGet($randomIndex);

        $vegetal = new Plant();
        $vegetal->setId(md5(rand()));
        $vegetal->setName($vegetalReference->getName());
        $vegetal->setDescription($vegetalReference->getDescription());
        $vegetal->setPicture($vegetalReference->getPicture());

        // FOOD
        $vegetal->setFoodModificator(
            rand($vegetalReference->getFoodMinModificator(), $vegetalReference->getFoodMaxModificator())
        );

        // WATER
        $vegetal->setWaterModificator(
            rand($vegetalReference->getWaterMinModificator(), $vegetalReference->getWaterMaxModificator())
        );

        // ENERGY
        $vegetal->setEnergyModificator(
            rand($vegetalReference->getEnergyMinModificator(), $vegetalReference->getEnergyMaxModificator())
        );

        // HEALTH
        $vegetal->setHealthModificator(
            rand($vegetalReference->getHealthMinModificator(), $vegetalReference->getHealthMaxModificator())
        );

        return $vegetal;
    }
}
