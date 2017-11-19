<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    /** @var string */
    protected $id;

    /** @var string */
    private $github_id;

    /** @var string */
    private $github_access_token;

    /** @var \DateTime */
    private $date_registered;

    /** @var ArrayCollection */
    private $characters;

    public function getGithubId()
    {
        return $this->github_id;
    }

    public function setGithubId($github_id)
    {
        $this->github_id = $github_id;
    }

    public function getGithubAccessToken()
    {
        return $this->github_access_token;
    }

    public function setGithubAccessToken($github_access_token)
    {
        $this->github_access_token = $github_access_token;
    }

    public function getDateRegistered()
    {
        return $this->date_registered;
    }

    public function setDateRegistered($registeredDate)
    {
        $this->date_registered = $registeredDate;
    }

    /**
     * @return ArrayCollection
     */
    public function getCharacters(): ArrayCollection
    {
        return $this->characters;
    }

    /**
     * @param ArrayCollection $characters
     */
    public function setCharacters(ArrayCollection $characters)
    {
        $this->characters = $characters;
    }

    /**
     * @return Character|null
     */
    public function getCurrentCharacter(): ?Character
    {
        $activeCharacter = $this->characters->filter(function (Character $character) {
            return $character->isActive();
        })->first();

        return (false === $activeCharacter) ? null : $activeCharacter;
    }
}
