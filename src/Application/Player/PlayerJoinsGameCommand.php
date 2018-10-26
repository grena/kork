<?php

declare(strict_types=1);

namespace App\Application\Player;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerJoinsGameCommand
{
    /** @var string */
    public $playerId;

    /** @var string */
    public $gameId;
}
