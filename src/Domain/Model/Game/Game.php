<?php

declare(strict_types=1);

namespace App\Domain\Model\Game;

use Webmozart\Assert\Assert;

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

    /** @var TravelStartAt */
    private $travelStartAt;

    /** @var TravelStopAt */
    private $travelStopAt;

    private function __construct(
        GameIdentifier $id,
        GameCreatedAt $createdAt,
        GameStarted $started,
        GameFinished $finished,
        TravelStartAt $travelStartAt,
        TravelStopAt $travelStopAt
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->started = $started;
        $this->finished = $finished;
        $this->travelStopAt = $travelStopAt;
        $this->travelStartAt = $travelStartAt;
    }

    public static function createNew(GameIdentifier $gameIdentifier): self
    {
        return new self(
            $gameIdentifier,
            GameCreatedAt::now(),
            GameStarted::fromBoolean(false),
            GameFinished::fromBoolean(false),
            TravelStartAt::fromNull(),
            TravelStopAt::fromNull()
        );
    }

    public static function fromNormalized($normalizedGame): self
    {
        Assert::isArray($normalizedGame, 'Normalized game should be an array');
        $requiredKeys = [
            'id',
            'created_at',
            'started',
            'finished',
            'travel_start_at',
            'travel_stop_at',
        ];

        foreach ($requiredKeys as $requiredKey) {
            Assert::keyExists(
                $normalizedGame,
                $requiredKey,
                sprintf('Normalized game requires the key "%s"', $requiredKey)
            );
        }

        return new self(
            GameIdentifier::fromString($normalizedGame['id']),
            GameCreatedAt::fromString($normalizedGame['created_at']),
            GameStarted::fromBoolean($normalizedGame['started']),
            GameFinished::fromBoolean($normalizedGame['finished']),
            TravelStartAt::fromNormalized($normalizedGame['travel_start_at']),
            TravelStopAt::fromNormalized($normalizedGame['travel_stop_at'])
        );
    }

    public function normalize(): array
    {
        return [
            'id' => $this->getId()->normalize(),
            'created_at' => $this->getCreatedAt()->normalize(),
            'started' => $this->started->normalize(),
            'finished' => $this->finished->normalize(),
            'travel_start_at' => $this->getTravelStartAt()->normalize(),
            'travel_stop_at' => $this->getTravelStopAt()->normalize(),
        ];
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

    public function start()
    {
        if ($this->isStarted()) {
            throw new \LogicException('Cannot start a game already started');
        }

        $this->started = GameStarted::fromBoolean(true);
    }

    public function finish()
    {
        if (!$this->isStarted()) {
            throw new \LogicException('Cannot finish a not started game');
        }

        if ($this->isFinished()) {
            throw new \LogicException('Cannot finish game already finished');
        }

        $this->finished = GameFinished::fromBoolean(true);
    }

    public function getStarted(): GameStarted
    {
        return $this->started;
    }

    public function setStarted(GameStarted $started): void
    {
        $this->started = $started;
    }

    public function getFinished(): GameFinished
    {
        return $this->finished;
    }

    public function setFinished(GameFinished $finished): void
    {
        $this->finished = $finished;
    }

    public function getTravelStartAt(): TravelStartAt
    {
        return $this->travelStartAt;
    }

    public function setTravelStartAt(TravelStartAt $travelStartAt): void
    {
        $this->travelStartAt = $travelStartAt;
    }

    public function getTravelStopAt(): TravelStopAt
    {
        return $this->travelStopAt;
    }

    public function setTravelStopAt(TravelStopAt $travelStopAt): void
    {
        $this->travelStopAt = $travelStopAt;
    }
}
