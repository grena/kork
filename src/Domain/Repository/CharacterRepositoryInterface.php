<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Character;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface CharacterRepositoryInterface
{
    public function add(Character $character): void;
}
