<?php

declare(strict_types=1);

namespace App\Domain\Provider\Character;

use App\Domain\Model\Character\CharacterName;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface NameProviderInterface
{
    /**
     * @return CharacterName[]
     */
    public function allForGender(string $gender): array;
}
