<?php

declare(strict_types=1);

namespace App\Domain\Model\Character;

use App\Domain\Model\Game\GameIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class Character
{
    /** @var CharacterIdentifier */
    private $id;

    /** @var GameIdentifier */
    private $gameIdentifier;

    /** @var string */
    private $playerIdentifier;

    /** @var CharacterName */
    private $name;

    /** @var CharacterPicture */
    private $picture;

    private function __construct(
        CharacterIdentifier $id,
        GameIdentifier $gameIdentifier,
        string $playerIdentifier,
        CharacterName $name,
        CharacterPicture $picture
    ) {
        $this->id = $id;
        $this->gameIdentifier = $gameIdentifier;
        $this->playerIdentifier = $playerIdentifier;
        $this->name = $name;
        $this->picture = $picture;
    }

    public static function create(
        CharacterIdentifier $id,
        GameIdentifier $gameIdentifier,
        string $playerIdentifier,
        CharacterName $name,
        CharacterPicture $picture
    ) {
        return new self(
            $id,
            $gameIdentifier,
            $playerIdentifier,
            $name,
            $picture
        );
    }

    public function getId(): CharacterIdentifier
    {
        return $this->id;
    }

    public function getGameIdentifier(): GameIdentifier
    {
        return $this->gameIdentifier;
    }

    public function getPlayerIdentifier(): string
    {
        return $this->playerIdentifier;
    }

    public function getName(): CharacterName
    {
        return $this->name;
    }

    public function getPicture(): CharacterPicture
    {
        return $this->picture;
    }
}
