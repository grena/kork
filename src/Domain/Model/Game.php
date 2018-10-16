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
}
