<?php

declare(strict_types=1);

namespace App\Domain\Model\Game;

use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class TravelStartAt
{
    /** @var CarbonInterface|null */
    private $travelStartAt;

    private function __construct(?CarbonInterface $travelStartAt)
    {
        $this->travelStartAt = $travelStartAt;
    }

    public static function fromNull()
    {
        return new self(null);
    }

    public static function fromString(string $travelStartAt): self
    {
        $travelStartAt = Carbon::createFromFormat('Y-m-d H:i:s', $travelStartAt);

        return new self($travelStartAt);
    }

    public static function fromNormalized(?string $normalized)
    {
        if (null === $normalized) {
            return self::fromNull();
        }

        return self::fromString($normalized);
    }

    public static function now(): self
    {
        $createdAt = Carbon::now();

        return new self($createdAt);
    }

    public function normalize(): ?string
    {
        if (null === $this->travelStartAt) {
            return null;
        }

        return $this->travelStartAt->toDateTimeString();
    }

    public function isNull(): bool
    {
        return $this->travelStartAt === null;
    }

    public function __toString()
    {
        if (null === $this->travelStartAt) {
            return '';
        }

        return $this->travelStartAt->toDateTimeString();
    }
}
