<?php

declare(strict_types=1);

namespace App\Domain\Provider\Planet;

use App\Domain\Model\Planet\Planet;
use App\Domain\Model\Planet\PlanetPicture;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface PictureProviderInterface
{
    public function forPlanet(Planet $planet): PlanetPicture;
}
