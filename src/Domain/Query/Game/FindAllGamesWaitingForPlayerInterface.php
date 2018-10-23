<?php

declare(strict_types=1);

namespace App\Domain\Query\Game;

use App\Domain\Model\Game\GameIdentifier;

/**
 * Find all games that an in a "Waiting for Player" state, meaning
 * they are not started nor finished.
 *
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface FindAllGamesWaitingForPlayerInterface
{
    /**
     * @return GameIdentifier[]
     */
    public function __invoke(): array;
}
