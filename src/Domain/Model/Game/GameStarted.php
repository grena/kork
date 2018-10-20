<?php

declare(strict_types=1);

namespace App\Domain\Model\Game;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameStarted
{
    /** @var bool */
    private $isGameStarted;

    private function __construct(bool $isGameStarted)
    {
        $this->isGameStarted = $isGameStarted;
    }

    public static function fromBoolean(bool $isGameStarted): self
    {
        return new self($isGameStarted);
    }

    public function isYes(): bool
    {
        return $this->isGameStarted;
    }

    public function normalize(): bool
    {
        return $this->isGameStarted;
    }
}
