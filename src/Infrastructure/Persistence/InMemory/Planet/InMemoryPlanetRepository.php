<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Planet;

use App\Domain\Model\Planet\Planet;
use App\Domain\Model\Planet\PlanetIdentifier;
use App\Domain\Repository\PlanetRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryPlanetRepository implements PlanetRepositoryInterface
{
    /** @var Planet[] */
    private $planets = [];

    public function nextIdentifier(): PlanetIdentifier
    {
        return PlanetIdentifier::fromString(
            (string) count($this->planets)
        );
    }
}
