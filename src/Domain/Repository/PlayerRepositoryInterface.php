<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Player;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface PlayerRepositoryInterface
{
    /**
     * @throws PlayerNotFoundException
     */
    public function getById(string $id): Player;

    /**
     * @throws PlayerNotFoundException
     */
    public function getByUsername(string $username): Player;

    public function add(Player $player): void;
}
