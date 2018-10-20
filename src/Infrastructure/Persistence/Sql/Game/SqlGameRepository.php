<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Game;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameCreatedAt;
use App\Domain\Model\Game\GameFinished;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Model\Game\GameStarted;
use App\Domain\Repository\GameNotFoundException;
use App\Domain\Repository\GameRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Uuid;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlGameRepository implements GameRepositoryInterface
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function add(Game $game): void
    {
        $insert = <<<SQL
        INSERT INTO `game`
            (id, created_at, started, finished)
        VALUES 
            (:id, :created_at, :started, :finished);
SQL;
        $affectedRows = $this->sqlConnection->executeUpdate(
            $insert,
            [
                'id' => (string) $game->getId(),
                'created_at' => (string) $game->getCreatedAt(),
                'started' => $game->isStarted(),
                'finished' => $game->isFinished(),
            ],
            [
                'started' => Type::getType(Type::BOOLEAN),
                'finished' => Type::getType(Type::BOOLEAN),
            ]
        );

        if ($affectedRows > 1) {
            throw new \RuntimeException(
                sprintf('Expected to add one game, but %d rows were affected', $affectedRows)
            );
        }
    }

    public function getByIdentifier(string $id): Game
    {
        $fetch = <<<SQL
        SELECT *
        FROM `game`
        WHERE id = :id;
SQL;
        $statement = $this->sqlConnection->executeQuery(
            $fetch,
            ['id' => (string) $id]
        );

        $result = $statement->fetch();
        if (!$result) {
            throw GameNotFoundException::withId($id);
        }

        return $this->hydrateGame($result);
    }

    public function nextIdentifier(): string
    {
        return Uuid::uuid4()->toString();
    }

    private function hydrateGame($result): Game
    {
        $platform = $this->sqlConnection->getDatabasePlatform();
        $isStarted = Type::getType(Type::BOOLEAN)->convertToPHPValue($result['started'], $platform);
        $isFinished = Type::getType(Type::BOOLEAN)->convertToPHPValue($result['finished'], $platform);

        return Game::create(
            GameIdentifier::fromString($result['id']),
            GameCreatedAt::fromString($result['created_at']),
            GameStarted::fromBoolean($isStarted),
            GameFinished::fromBoolean($isFinished)
        );
    }
}
