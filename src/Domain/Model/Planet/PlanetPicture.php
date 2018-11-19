<?php

declare(strict_types=1);

namespace App\Domain\Model\Planet;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlanetPicture
{
    /** @var string */
    private $filePath;

    private function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public static function fromString(string $filePath): self
    {
        return new self($filePath);
    }

    public static function empty(): self
    {
        return new self('');
    }

    public function __toString(): string
    {
        return $this->filePath;
    }

    public function normalize(): string
    {
        return $this->filePath;
    }
}
