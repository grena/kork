<?php

declare(strict_types=1);

namespace App\Application\Game;

use App\Domain\Model\User;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CreateGameCommand
{
    /** @var User */
    public $player;
}
