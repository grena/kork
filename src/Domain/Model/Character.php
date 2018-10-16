<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="character")
 * @ORM\Entity
 */
class Character
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Game", inversedBy="characters")
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Player", inversedBy="characters")
     */
    private $player;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;
}
