<?php

declare(strict_types=1);

namespace App\Domain\Generator\Planet;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Model\Planet\Planet;
use App\Domain\Model\Planet\PlanetBiome;
use App\Domain\Model\Planet\PlanetPicture;
use App\Domain\Model\Planet\PlanetSeed;
use App\Domain\Provider\Planet\PictureProviderInterface;
use App\Domain\Repository\PlanetRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlanetGenerator
{
    /** @var NameGenerator */
    private $nameGenerator;

    /** @var PictureProviderInterface */
    private $pictureProvider;

    /** @var PlanetRepositoryInterface */
    private $planetRepository;

    public function __construct(
        NameGenerator $nameGenerator,
        PictureProviderInterface $pictureProvider,
        PlanetRepositoryInterface $planetRepository
    ) {
        $this->nameGenerator = $nameGenerator;
        $this->pictureProvider = $pictureProvider;
        $this->planetRepository = $planetRepository;
    }

    public function forGame(GameIdentifier $gameIdentifier): Planet
    {
        $planet = Planet::create(
            $this->planetRepository->nextIdentifier(),
            PlanetSeed::fromString((string) rand()),
            $gameIdentifier,
            $this->nameGenerator->getName(),
            PlanetPicture::empty(),
            PlanetBiome::fromString($this->getRandomBiome())
        );

        $picture = $this->pictureProvider->forPlanet($planet);
        $planet->setPicture($picture);

        return $planet;
    }

    private function getRandomBiome(): string
    {
        $biomes = [
            'ashes',
            'atoll',
            'forest',
            'lava',
            'toxic',
        ];

        shuffle($biomes);

        return current($biomes);
    }
}
