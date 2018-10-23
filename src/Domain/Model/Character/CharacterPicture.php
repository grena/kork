<?php

declare(strict_types=1);

namespace App\Domain\Model\Character;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CharacterPicture
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

    public function __toString(): string
    {
        return $this->filePath;
    }

    public function normalize(): string
    {
        return $this->filePath;
    }
}
