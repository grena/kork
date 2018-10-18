<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User;

/**
 * @ORM\Table(name="player")
 * @ORM\Entity
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="password", column=@ORM\Column(type="string", name="password", length=255, nullable=true))
 * })
 */
class Player extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $github_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $github_access_token;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setGithubId($github_id): void
    {
        $this->github_id = $github_id;
    }

    public function setGithubAccessToken($github_access_token): void
    {
        $this->github_access_token = $github_access_token;
    }

    public function getGithubId(): ?string
    {
        return $this->github_id;
    }

    public function getGithubAccessToken(): ?string
    {
        return $this->github_access_token;
    }
}
