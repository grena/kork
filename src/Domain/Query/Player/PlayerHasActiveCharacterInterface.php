<?php

declare(strict_types=1);

namespace App\Domain\Query\Player;

/**
 * Tells if the given Player has an active character.
 * This means a character in a game that is in a "Waiting for player" or "Running" state.
 *
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface PlayerHasActiveCharacterInterface
{
    public function withPlayer(string $playerIdentifier): bool;
}
