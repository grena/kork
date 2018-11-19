<?php

declare(strict_types=1);

namespace App\Domain\Model\Planet;

use Webmozart\Assert\Assert;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlanetIdentifier
{
    /** @var string */
    private $identifier;

    private function __construct(string $identifier)
    {
        Assert::stringNotEmpty($identifier, 'Planet identifier cannot be empty');

        $this->identifier = $identifier;
    }

    public static function fromString(string $identifier): self
    {
        return new self($identifier);
    }

    public function __toString(): string
    {
        return $this->identifier;
    }

    public function normalize(): string
    {
        return $this->identifier;
    }

    public function equals(PlanetIdentifier $identifier)
    {
        return $this->normalize() === $identifier->normalize();
    }
}
