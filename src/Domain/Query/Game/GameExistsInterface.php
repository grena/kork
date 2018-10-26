<?php

declare(strict_types=1);

namespace App\Domain\Query\Game;

use App\Domain\Model\Game\GameIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface GameExistsInterface
{
    public function withIdentifier(GameIdentifier $gameIdentifier): bool;
}
