<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="game")
 * @ORM\Entity
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=false, options={"default" : 1})
     */
//    private $day;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
//    private $startedAt;

    /**
     * @ORM\Column(type="datetime")
     */
//    private $finishedAt;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default" : false})
     */
    private $started;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default" : false})
     */
    private $finished;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function isStarted(): bool
    {
        return $this->started;
    }

    public function setStarted($started): void
    {
        $this->started = $started;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setFinished($finished): void
    {
        $this->finished = $finished;
    }
}
