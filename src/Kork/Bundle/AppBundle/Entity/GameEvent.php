<?php

namespace Kork\Bundle\AppBundle\Entity;

class GameEvent
{
    /** @var string */
    private $id;

    /** @var string */
    private $initiator;

    /** @var string */
    private $initiatorType;

    /** @var string */
    private $action;

    /** @var string */
    private $target;

    /** @var string */
    private $targetType;

    /** @var int */
    private $dayNum;

    /** @var string */
    private $time;

    /** @var \DateTime */
    private $datetime;

    /** @var Game */
    private $game;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getInitiator(): string
    {
        return $this->initiator;
    }

    /**
     * @param string $initiator
     */
    public function setInitiator(string $initiator)
    {
        $this->initiator = $initiator;
    }

    /**
     * @return string
     */
    public function getInitiatorType(): string
    {
        return $this->initiatorType;
    }

    /**
     * @param string $initiatorType
     */
    public function setInitiatorType(string $initiatorType)
    {
        $this->initiatorType = $initiatorType;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action)
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target)
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getTargetType(): string
    {
        return $this->targetType;
    }

    /**
     * @param string $targetType
     */
    public function setTargetType(string $targetType)
    {
        $this->targetType = $targetType;
    }

    /**
     * @return int
     */
    public function getDayNum(): int
    {
        return $this->dayNum;
    }

    /**
     * @param int $dayNum
     */
    public function setDayNum(int $dayNum)
    {
        $this->dayNum = $dayNum;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time)
    {
        $this->time = $time;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime(): \DateTime
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime(\DateTime $datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }

    /**
     * @param Game $game
     */
    public function setGame(Game $game)
    {
        $this->game = $game;
    }
}
