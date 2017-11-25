<?php

namespace Kork\Component\Planet;

use Doctrine\Common\Collections\ArrayCollection;
use Kork\Bundle\AppBundle\Entity\Game;
use Kork\Bundle\AppBundle\Entity\Planet;
use Kork\Component\Vegetal\VegetalGenerator;

class PlanetGenerator
{
    public const MIN_VEGETALS = 1;
    public const MAX_VEGETALS = 5;

    /** @var VegetalGenerator */
    private $vegetalGenerator;

    public function __construct(VegetalGenerator $vegetalGenerator)
    {
        $this->vegetalGenerator = $vegetalGenerator;
    }

    public function generate(Game $game, int $dayNumber)
    {
        $planet = new Planet();

        $nbOfVegetals = rand(self::MIN_VEGETALS, self::MAX_VEGETALS);
        $vegetals = new ArrayCollection();
        for ($i = 0; $i < $nbOfVegetals; $i++) {
            $vegetals->add($this->vegetalGenerator->generate($game));
        }

        $planet->setVegetals($vegetals);

        $game->getPlanets()->add($planet);
    }
}
