<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication;

use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User provider to handle oAuth responses.
 *
 * @author Adrien Pétremann <hello@grena.fr>
 *
 * Credits: https://gist.github.com/danvbe/4476697
 */
class FOSUBUserProvider extends BaseClass
{
    public function __construct(UserManagerInterface $userManager, array $properties)
    {
        parent::__construct($userManager, $properties);
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);

        $username = $response->getUsername();
        // On connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($service);
        $setter_id = $setter . 'Id';
        $setter_token = $setter . 'AccessToken';

        // "Disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy([$property => $username])) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        // Connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        var_dump($response->getUsername());

//        return parent::loadUserByOAuthUserResponse($response);

        $username = $response->getUsername();
        $user = $this->userManager->findUserBy([$this->getProperty($response) => $username]);

//        // When the user is registering
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($service);
            $setter_id = $setter . 'Id';
            $setter_token = $setter . 'AccessToken';

            // Create new user here
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            $user->setUsername($response->getNickname());
            $user->setEnabled(true);
//            $user->setDateRegistered(new \DateTime());

            $this->userManager->updateUser($user);

            return $user;
        }

        // If user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        // Update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }
}
