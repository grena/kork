<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Player;

use App\Domain\Model\Player;
use App\Domain\Repository\PlayerNotFoundException;
use App\Domain\Repository\PlayerRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryPlayerRepository implements PlayerRepositoryInterface
{
    /** @var Player[] */
    public $players = [];

    /**
     * @throws PlayerNotFoundException
     */
    public function getById(string $id): Player
    {
        foreach ($this->players as $player) {
            if ($id === $player->getId()) {
                return $player;
            }
        }

        throw PlayerNotFoundException::withId($id);
    }

    /**
     * @throws PlayerNotFoundException
     */
    public function getByUsername(string $username): Player
    {
        foreach ($this->players as $player) {
            if ($username === $player->getUsername()) {
                return $player;
            }
        }

        throw PlayerNotFoundException::withUsername($username);
    }

    public function add(Player $player): void
    {
        $this->players[$player->getId()] = $player;
    }

    public function reset(): void
    {
        $this->players = [];
    }
}
