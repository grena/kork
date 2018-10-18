<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Player;

use App\Domain\Model\Player;
use App\Domain\Repository\PlayerNotFoundException;
use App\Domain\Repository\PlayerRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use PDO;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlPlayerRepository implements PlayerRepositoryInterface
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function getById(string $id): Player
    {
        $fetch = <<<SQL
        SELECT *
        FROM player
        WHERE id = :id;
SQL;
        $statement = $this->sqlConnection->executeQuery(
            $fetch,
            [
                'id' => $id,
            ]
        );

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw PlayerNotFoundException::withId($id);
        }

        return $this->hydratePlayer($result);
    }

    public function getByUsername(string $username): Player
    {
        $fetch = <<<SQL
        SELECT *
        FROM player
        WHERE username = :username;
SQL;
        $statement = $this->sqlConnection->executeQuery(
            $fetch,
            [
                'username' => $username,
            ]
        );

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw PlayerNotFoundException::withUsername($username);
        }

        return $this->hydratePlayer($result);
    }

    public function add(Player $player): void
    {
        $insert = <<<SQL
        INSERT INTO `player`
            (id, username, username_canonical, enabled, salt, last_login, confirmation_token, password_requested_at, roles, github_id, github_access_token, email, email_canonical, password)
        VALUES 
            (:id, :username, :username_canonical, :enabled, :salt, :last_login, :confirmation_token, :password_requested_at, :roles, :github_id, :github_access_token, :email, :email_canonical, :password);
SQL;
        $affectedRows = $this->sqlConnection->executeUpdate(
            $insert,
            [
                'id' => $player->getId(),
                'username' => $player->getUsername(),
                'username_canonical' => $player->getUsernameCanonical(),
                'enabled' => (bool) $player->isEnabled(),
                'salt' => $player->getSalt(),
                'last_login' => $player->getLastLogin(),
                'confirmation_token' => $player->getConfirmationToken(),
                'password_requested_at' => $player->getPasswordRequestedAt(),
                'roles' => $player->getRoles(),
                'github_id' => $player->getGithubId(),
                'github_access_token' => $player->getGithubAccessToken(),
                'email' => $player->getEmail(),
                'email_canonical' => $player->getEmailCanonical(),
                'password' => $player->getPassword(),
            ],
            [
                'roles' => Type::TARRAY,
            ]
        );

        if ($affectedRows > 1) {
            throw new \RuntimeException(
                sprintf('Expected to add one player, but %d rows were affected', $affectedRows)
            );
        }
    }

    private function hydratePlayer($result): Player
    {
        $platform = $this->sqlConnection->getDatabasePlatform();
        $roles = Type::getType(Type::TARRAY)->convertToPHPValue($result['roles'], $platform);

        $player = new Player();
        $player->setId($result['id']);
        $player->setUsername($result['username']);
        $player->setUsernameCanonical($result['username_canonical']);
        $player->setEnabled($result['enabled']);
        $player->setSalt($result['salt']);
        $player->setConfirmationToken($result['confirmation_token']);
        $player->setPasswordRequestedAt($result['password_requested_at']);
        $player->setRoles($roles);
        $player->setGithubId($result['github_id']);
        $player->setGithubAccessToken($result['github_access_token']);
        $player->setEmail($result['email']);
        $player->setEmailCanonical($result['email_canonical']);
        $player->setPassword($result['password']);

        if (null !== $result['last_login']) {
            $player->setLastLogin(new \DateTime($result['last_login']));
        }

        return $player;
    }

    // TODO: implement nextIdentifier method
}
