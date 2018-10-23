<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterIdentifier;
use App\Domain\Model\Game\GameIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface CharacterRepositoryInterface
{
    public function add(Character $character): void;

    public function nextIdentifier(): CharacterIdentifier;

    /**
     * @return Character[]
     */
    public function findAllByGame(GameIdentifier $gameIdentifier): array;
}
