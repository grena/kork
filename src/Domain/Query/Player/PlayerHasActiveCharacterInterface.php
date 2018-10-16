<?php

declare(strict_types=1);

namespace App\Domain\Query\Player;

use App\Domain\Model\Player;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface PlayerHasActiveCharacterInterface
{
    public function withPlayer(Player $player): bool;
}
