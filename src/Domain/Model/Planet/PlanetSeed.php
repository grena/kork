<?php

declare(strict_types=1);

namespace App\Domain\Model\Planet;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlanetSeed
{
    /** @var int */
    private $seed;

    private function __construct(int $seed)
    {
        $this->seed = $seed;
    }

    public static function fromString(string $seed): self
    {
        return new self(intval($seed));
    }

    public function intValue()
    {
        return $this->seed;
    }

    public function __toString(): string
    {
        return (string) $this->seed;
    }

    public function normalize(): int
    {
        return $this->seed;
    }
}
