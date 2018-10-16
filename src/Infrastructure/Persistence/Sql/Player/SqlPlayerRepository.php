<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Player;

use App\Domain\Model\Player;
use App\Domain\Repository\PlayerNotFoundException;
use App\Domain\Repository\PlayerRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use PDO;
use Symfony\Component\Validator\Constraints\DateTime;

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
        $player->setLastLogin(new \DateTime($result['last_login']));
        $player->setConfirmationToken($result['confirmation_token']);
        $player->setPasswordRequestedAt($result['password_requested_at']);
        $player->setRoles($roles);
        $player->setGithubId($result['github_id']);
        $player->setGithubAccessToken($result['github_access_token']);
        $player->setEmail($result['email']);
        $player->setEmailCanonical($result['email_canonical']);
        $player->setPassword($result['password']);

        return $player;
    }
}
