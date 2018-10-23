<?php

declare(strict_types=1);

namespace App\Domain\Generator\Character;

use App\Domain\Model\Character\Character;
use App\Domain\Model\Game\GameIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface CharacterGeneratorInterface
{
    public function forGameAndPlayer(GameIdentifier $gameIdentifier, string $playerIdentifier): Character;
}
