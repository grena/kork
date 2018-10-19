<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Game;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface GameRepositoryInterface
{
    public function add(Game $game): void;

    public function getByIdentifier(string $id): Game;

    public function nextIdentifier(): string;
}
