<?php

declare(strict_types=1);

namespace App\Domain\Model\Game;

use Carbon\Carbon;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameCreatedAt
{
    /** @var Carbon */
    private $createdAt;

    private function __construct(Carbon $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public static function fromString(string $createdAt): self
    {
        $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt);

        return new self($createdAt);
    }

    public static function fromDateTime(\DateTime $dateTime): self
    {
        $createdAt = Carbon::instance($dateTime);

        return new self($createdAt);
    }

    public static function now(): self
    {
        $createdAt = Carbon::now();

        return new self($createdAt);
    }

    public function normalize(): string
    {
        return $this->createdAt->toDateTimeString();
    }

    public function __toString()
    {
        return $this->createdAt->toDateTimeString();
    }
}
