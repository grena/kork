<?php

declare(strict_types=1);

namespace App\Domain\Model\Planet;

use Webmozart\Assert\Assert;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlanetBiome
{
    /** @var string */
    private $biomeName;

    private function __construct(string $biomeName)
    {
        Assert::stringNotEmpty($biomeName, 'Planet biome cannot be empty');

        $this->biomeName = $biomeName;
    }

    public static function fromString(string $biomeName): self
    {
        return new self($biomeName);
    }

    public function __toString(): string
    {
        return $this->biomeName;
    }

    public function normalize(): string
    {
        return $this->biomeName;
    }
}
