<?php

namespace Kork\Component\Game;

use Kork\Bundle\AppBundle\Entity\Game;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 * @copyright Copyright (c) 2017, Mech Shrimp Studios.
 */
interface GameRepositoryInterface
{
    /**
     * @param string $code
     *
     * @return Game|null
     */
    public function findOneByCode(string $code): ?Game;
}
