<?php

declare(strict_types=1);

namespace App\Domain\Event\Game;

use App\Domain\Event\EventInterface;
use App\Domain\Model\Game\GameIdentifier;

/**
 * This event is triggered when a Player joins a Game.
 *
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerJoinedGameEvent implements EventInterface
{
    /** @var string */
    private $playerIdentifier;

    /** @var GameIdentifier */
    private $gameIdentifier;

    private function __construct(string $playerIdentifier, GameIdentifier $gameIdentifier)
    {
        $this->playerIdentifier = $playerIdentifier;
        $this->gameIdentifier = $gameIdentifier;
    }

    public static function create(string $playerIdentifier, GameIdentifier $gameIdentifier)
    {
        return new self($playerIdentifier, $gameIdentifier);
    }

    public function getName(): string
    {
        return 'game.player.joined';
    }

    public function getPlayerIdentifier(): string
    {
        return $this->playerIdentifier;
    }

    public function getGameIdentifier(): GameIdentifier
    {
        return $this->gameIdentifier;
    }
}
