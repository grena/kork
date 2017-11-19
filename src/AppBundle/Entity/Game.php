<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Game
{
    /** @var string */
    private $id;

    /** @var \DateTime */
    private $date_creation;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param \DateTime $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }
}
