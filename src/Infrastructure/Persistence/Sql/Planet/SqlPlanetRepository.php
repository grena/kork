<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Planet;

use App\Domain\Model\Planet\PlanetIdentifier;
use App\Domain\Repository\PlanetRepositoryInterface;
use Ramsey\Uuid\Uuid;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlPlanetRepository implements PlanetRepositoryInterface
{
    public function nextIdentifier(): PlanetIdentifier
    {
        return PlanetIdentifier::fromString(
            Uuid::uuid4()->toString()
        );
    }
}
