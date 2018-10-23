<?php

declare(strict_types=1);

namespace App\Domain\Provider\Character;

use App\Domain\Model\Character\CharacterPicture;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface PictureProviderInterface
{
    /**
     * @return CharacterPicture[]
     */
    public function allForGender(string $gender): array;
}
