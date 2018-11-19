<?php

declare(strict_types=1);

namespace App\Domain\Model\Planet;

use Webmozart\Assert\Assert;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlanetName
{
    /** @var string */
    private $name;

    private function __construct(string $name)
    {
        Assert::stringNotEmpty($name, 'Planet name cannot be empty');

        $this->name = $name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function normalize(): string
    {
        return $this->name;
    }
}
