<?php

namespace Kork\Bundle\AppBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Kork\Bundle\AppBundle\Entity\Game;
use Kork\Component\Game\GameRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 * @copyright Copyright (c) 2017, Mech Shrimp Studios.
 */
class GameRepository extends EntityRepository implements GameRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findOneByCode(string $code): Game
    {
        $game = $this->findOneBy(['code' => $code]);

        if ($game instanceof Game) {
            return $game;
        }

        return null;
    }
}
