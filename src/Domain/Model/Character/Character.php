<?php

declare(strict_types=1);

namespace App\Domain\Model\Character;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Player;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class Character
{
    /** @var CharacterIdentifier */
    private $id;

    /** @var Game */
    private $game;

    /** @var Player */
    private $player;

    /** @var CharacterName */
    private $name;

    private function __construct(CharacterIdentifier $id, Game $game, Player $player, CharacterName $name)
    {
        $this->id = $id;
        $this->game = $game;
        $this->player = $player;
        $this->name = $name;
    }

    public static function create(CharacterIdentifier $id, Game $game, Player $player, CharacterName $name)
    {
        return new self($id, $game, $player, $name);
    }

    public function getId(): CharacterIdentifier
    {
        return $this->id;
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getName(): CharacterName
    {
        return $this->name;
    }
}
