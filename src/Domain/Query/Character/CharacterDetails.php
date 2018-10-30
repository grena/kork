<?php

declare(strict_types=1);

namespace App\Domain\Query\Character;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CharacterDetails
{
    /** @var string */
    public $playerIdentifier;

    /** @var string */
    public $playerUsername;

    /** @var string */
    public $name;

    /** @var string */
    public $picture;

    public function normalize(): array
    {
        return [
            'name' => $this->name,
            'picture' => $this->picture,
            'player_id' => $this->playerIdentifier,
            'player_username' => $this->playerUsername,
        ];
    }
}
