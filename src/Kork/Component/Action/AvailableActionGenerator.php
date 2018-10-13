<?php

namespace Kork\Component\Action;


use Doctrine\Common\Collections\ArrayCollection;
use Kork\Bundle\AppBundle\Entity\AvailableAction;
use Kork\Bundle\AppBundle\Entity\Game;

class AvailableActionGenerator
{
    public function generate(Game $game)
    {
        $planet = $game->getCurrentPlanet();

        $availableActions = new ArrayCollection();

        // Generate actions for vegetals (TODO: register available action for each type of entity on the planet)
        foreach ($planet->getVegetals() as $vegetal) {
            $availableAction = new AvailableAction();
            $availableAction->setAction(AvailableAction::COLLECT_PLANT);
            $availableAction->setTarget($vegetal);
            $availableAction->setDuration(new \DateInterval('PT1H'));
            $availableAction->setPaCost(2);
            $availableActions->add($availableAction);

            $availableAction = new AvailableAction();
            $availableAction->setAction(AvailableAction::CONSUME_OUTDOOR);
            $availableAction->setTarget($vegetal);
            $availableAction->setDuration(new \DateInterval('PT45M'));
            $availableAction->setPaCost(2);
            $availableActions->add($availableAction);
        }

        $planet->setAvailableActions($availableActions);
    }
}
