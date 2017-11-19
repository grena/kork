<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Game
{
    /** @var string */
    private $id;

    /** @var \DateTime */
    private $date_creation;

    /** @var ArrayCollection */
    private $characters;

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

    /**
     * @return ArrayCollection
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @param ArrayCollection $characters
     */
    public function setCharacters($characters)
    {
        $this->characters = $characters;
    }

    public function addCharacter(Character $character)
    {
        if (null === $this->characters) {
            $this->characters = new ArrayCollection();
        }

        $this->characters->add($character);
    }
}
