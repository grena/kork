<?php

namespace Kork\Component\Game;


use Doctrine\Common\Collections\ArrayCollection;
use Kork\Bundle\AppBundle\Entity\Game;
use Kork\Component\Planet\PlanetGenerator;
use Kork\Component\Vegetal\VegetalReferenceGenerator;

class GameGenerator
{
    /** @var VegetalReferenceGenerator */
    private $vegetalReferenceGenerator;

    /** @var PlanetGenerator */
    private $planetGenerator;

    public function __construct(
        VegetalReferenceGenerator $vegetalReferenceGenerator,
        PlanetGenerator $planetGenerator
    ) {
        $this->vegetalReferenceGenerator = $vegetalReferenceGenerator;
        $this->planetGenerator = $planetGenerator;
    }

    public function generate(Game $game)
    {
        $this->vegetalReferenceGenerator->generate($game);

        $game->setPlanets(new ArrayCollection());
        for ($day = 1; $day <= $game->getCurrentDay(); $day++) {
            $this->planetGenerator->generate($game, $day);
        }
    }
}
