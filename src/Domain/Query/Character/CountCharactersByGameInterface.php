<?php

declare(strict_types=1);

namespace App\Domain\Query\Character;

use App\Domain\Model\Game\GameIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface CountCharactersByGameInterface
{
    public function withIdentifier(GameIdentifier $gameIdentifier): int;
}
