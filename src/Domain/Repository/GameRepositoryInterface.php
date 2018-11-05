<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface GameRepositoryInterface
{
    public function add(Game $game): void;

    public function update(Game $game): void;

    public function getByIdentifier(GameIdentifier $identifier): Game;

    public function findActiveForPlayer(string $playerIdentifier): ?Game;

    public function nextIdentifier(): GameIdentifier;
}
