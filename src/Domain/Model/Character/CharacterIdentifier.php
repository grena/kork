<?php

declare(strict_types=1);

namespace App\Domain\Model\Character;

use Webmozart\Assert\Assert;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CharacterIdentifier
{
    /** @var string */
    private $identifier;

    private function __construct(string $identifier)
    {
        Assert::stringNotEmpty($identifier, 'Character identifier cannot be empty');

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
}
