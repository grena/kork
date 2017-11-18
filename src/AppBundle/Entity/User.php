<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $github_id;

    /** @var string */
    protected $github_access_token;

    /** @var \DateTime */
    protected $date_registered;

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
}
