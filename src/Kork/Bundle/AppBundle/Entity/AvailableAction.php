<?php

namespace Kork\Bundle\AppBundle\Entity;


class AvailableAction
{
    public const COLLECT_PLANT = 'COLLECT_PLANT';
    public const CONSUME_OUTDOOR = 'CONSUME_OUTDOOR';

    /** @var string */
    private $action;

    /** @var mixed */
    private $target;

    /** @var int */
    private $paCost;

    /** @var \DateInterval */
    private $duration;

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
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @return int
     */
    public function getPaCost(): int
    {
        return $this->paCost;
    }

    /**
     * @param int $paCost
     */
    public function setPaCost(int $paCost)
    {
        $this->paCost = $paCost;
    }

    /**
     * @return \DateInterval
     */
    public function getDuration(): \DateInterval
    {
        return $this->duration;
    }

    /**
     * @param \DateInterval $duration
     */
    public function setDuration(\DateInterval $duration)
    {
        $this->duration = $duration;
    }
}
