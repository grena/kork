<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Planet\PlanetIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface PlanetRepositoryInterface
{
    public function nextIdentifier(): PlanetIdentifier;
}
