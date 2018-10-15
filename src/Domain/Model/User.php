<?php

declare(strict_types=1);

namespace App\Domain\Model;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="password", column=@ORM\Column(type="string", name="password", length=255, nullable=true))
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $github_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $github_access_token;

    public function setGithubId($github_id): void
    {
        $this->github_id = $github_id;
    }

    public function setGithubAccessToken($github_access_token): void
    {
        $this->github_access_token = $github_access_token;
    }
}
