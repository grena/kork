<?php

declare(strict_types=1);

namespace App\Provider;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use Psr\Log\LoggerInterface;

class UserProvider extends OAuthUserProvider
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * UserProvider constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        return parent::loadUserByOAuthUserResponse($response);
    }
}
