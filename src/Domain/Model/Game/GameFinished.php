<?php

declare(strict_types=1);

namespace App\Domain\Model\Game;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class GameFinished
{
    /** @var bool */
    private $isGameFinished;

    private function __construct(bool $isGameFinished)
    {
        $this->isGameFinished = $isGameFinished;
    }

    public static function fromBoolean(bool $isGameFinished): self
    {
        return new self($isGameFinished);
    }

    public function isYes(): bool
    {
        return $this->isGameFinished;
    }

    public function normalize(): bool
    {
        return $this->isGameFinished;
    }
}
