<?php

declare(strict_types=1);

namespace App\Domain\Model\Planet;

use App\Domain\Model\Game\GameIdentifier;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class Planet
{
    /** @var PlanetIdentifier */
    private $id;

    /** @var PlanetSeed */
    private $seed;

    /** @var GameIdentifier */
    private $gameId;

    /** @var PlanetName */
    private $name;

    /** @var PlanetPicture */
    private $picture;

    /** @var PlanetBiome */
    private $biome;

    private function __construct(
        PlanetIdentifier $id,
        PlanetSeed $seed,
        GameIdentifier $gameId,
        PlanetName $name,
        PlanetPicture $picture,
        PlanetBiome $biome
    ) {
        $this->id = $id;
        $this->seed = $seed;
        $this->gameId = $gameId;
        $this->name = $name;
        $this->picture = $picture;
        $this->biome = $biome;
    }

    public static function create(
        PlanetIdentifier $id,
        PlanetSeed $seed,
        GameIdentifier $gameId,
        PlanetName $name,
        PlanetPicture $picture,
        PlanetBiome $biome
    ): self {
        return new self(
            $id,
            $seed,
            $gameId,
            $name,
            $picture,
            $biome
        );
    }

    public function getId(): PlanetIdentifier
    {
        return $this->id;
    }

    public function setId(PlanetIdentifier $id): void
    {
        $this->id = $id;
    }

    public function getSeed(): PlanetSeed
    {
        return $this->seed;
    }

    public function setSeed(PlanetSeed $seed): void
    {
        $this->seed = $seed;
    }

    public function getGameId(): GameIdentifier
    {
        return $this->gameId;
    }

    public function setGameId(GameIdentifier $gameId): void
    {
        $this->gameId = $gameId;
    }

    public function getName(): PlanetName
    {
        return $this->name;
    }

    public function setName(PlanetName $name): void
    {
        $this->name = $name;
    }

    public function getPicture(): PlanetPicture
    {
        return $this->picture;
    }

    public function setPicture(PlanetPicture $picture): void
    {
        $this->picture = $picture;
    }

    public function getBiome(): PlanetBiome
    {
        return $this->biome;
    }

    public function setBiome(PlanetBiome $biome): void
    {
        $this->biome = $biome;
    }
}
