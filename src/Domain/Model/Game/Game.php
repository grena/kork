<?php

declare(strict_types=1);

namespace App\Domain\Model\Game;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class Game
{
    /** @var int */
    public const NUMBER_OF_PLAYERS_REQUIRED_TO_START = 5;

    /** @var GameIdentifier */
    private $id;

    /** @var GameCreatedAt */
    private $createdAt;

    /** @var GameStarted */
    private $started;

    /** @var GameFinished */
    private $finished;

    private function __construct(
        GameIdentifier $id,
        GameCreatedAt $createdAt,
        GameStarted $started,
        GameFinished $finished
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->started = $started;
        $this->finished = $finished;
    }

    public function getId(): GameIdentifier
    {
        return $this->id;
    }

    public function getCreatedAt(): GameCreatedAt
    {
        return $this->createdAt;
    }

    public function isStarted(): bool
    {
        return $this->started->isYes();
    }

    public function isFinished(): bool
    {
        return $this->finished->isYes();
    }

    public static function create(
        GameIdentifier $identifier,
        GameCreatedAt $createdAt,
        GameStarted $started,
        GameFinished $finished
    ): Game {
        return new self(
            $identifier,
            $createdAt,
            $started,
            $finished
        );
    }
}
