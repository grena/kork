<?php

declare(strict_types=1);

namespace App\Domain\Model\Game;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class TravelStopAt
{
    /** @var CarbonInterface|null */
    private $travelStopAt;

    private function __construct(?CarbonInterface $travelStopAt)
    {
        $this->travelStopAt = $travelStopAt;
    }

    public static function fromNull()
    {
        return new self(null);
    }

    public static function fromString(string $travelStopAt): self
    {
        $travelStopAt = Carbon::createFromFormat('Y-m-d H:i:s', $travelStopAt);

        return new self($travelStopAt);
    }

    public static function fromNormalized(?string $normalized)
    {
        if (null === $normalized) {
            return self::fromNull();
        }

        return self::fromString($normalized);
    }

    public static function fromTravelStartAndDuration(TravelStartAt $travelStartAt, string $duration)
    {
        $travelStart = CarbonImmutable::createFromFormat('Y-m-d H:i:s', $travelStartAt->normalize());

        return new self($travelStart->add($duration));
    }

    public function normalize(): ?string
    {
        if (null === $this->travelStopAt) {
            return null;
        }

        return $this->travelStopAt->toDateTimeString();
    }

    public function isNull(): bool
    {
        return $this->travelStopAt === null;
    }

    public function __toString()
    {
        if (null === $this->travelStopAt) {
            return '';
        }

        return $this->travelStopAt->toDateTimeString();
    }
}
