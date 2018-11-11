<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Game;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
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
            (id, created_at, started, finished, travel_start_at, travel_stop_at)
        VALUES 
            (:id, :created_at, :started, :finished, :travel_start_at, :travel_stop_at);
SQL;
        $affectedRows = $this->sqlConnection->executeUpdate(
            $insert,
            $game->normalize(),
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

    public function update(Game $game): void
    {
        $update = <<<SQL
        UPDATE 
            `game`
        SET
            created_at = :created_at, 
            started = :started, 
            finished = :finished,
            travel_start_at = :travel_start_at,
            travel_stop_at = :travel_stop_at
        WHERE 
            id = :id
SQL;
        $affectedRows = $this->sqlConnection->executeUpdate(
            $update,
            [
                'id' => $game->getId()->normalize(),
                'created_at' => $game->getCreatedAt()->normalize(),
                'started' => $game->isStarted(),
                'finished' => $game->isFinished(),
                'travel_start_at' => $game->getTravelStartAt()->normalize(),
                'travel_stop_at' => $game->getTravelStopAt()->normalize()
            ],
            [
                'started' => Type::getType(Type::BOOLEAN),
                'finished' => Type::getType(Type::BOOLEAN),
            ]
        );

        if ($affectedRows > 1) {
            throw new \RuntimeException(
                sprintf('Expected to update one game, but %d rows were affected', $affectedRows)
            );
        }
    }

    public function getByIdentifier(GameIdentifier $identifier): Game
    {
        $fetch = <<<SQL
        SELECT *
        FROM `game`
        WHERE id = :id;
SQL;
        $statement = $this->sqlConnection->executeQuery(
            $fetch,
            ['id' => (string) $identifier]
        );

        $result = $statement->fetch();
        if (!$result) {
            throw GameNotFoundException::withId($identifier);
        }

        return $this->hydrateGame($result);
    }

    public function nextIdentifier(): GameIdentifier
    {
        return GameIdentifier::fromString(
            Uuid::uuid4()->toString()
        );
    }

    public function findActiveForPlayer(string $playerIdentifier): ?Game
    {
        $fetch = <<<SQL
        SELECT g.*
        FROM `game` as g
        LEFT JOIN `character` as c
            ON g.id = c.game_id
        WHERE c.player_id = :playerId
        AND g.finished = false
SQL;
        $statement = $this->sqlConnection->executeQuery(
            $fetch,
            ['playerId' => (string) $playerIdentifier]
        );

        $result = $statement->fetch();
        if (!$result) {
            return null;
        }

        return $this->hydrateGame($result);
    }

    private function hydrateGame($result): Game
    {
        $platform = $this->sqlConnection->getDatabasePlatform();
        $result['started'] = Type::getType(Type::BOOLEAN)->convertToPHPValue($result['started'], $platform);
        $result['finished'] = Type::getType(Type::BOOLEAN)->convertToPHPValue($result['finished'], $platform);

        return Game::fromNormalized($result);
    }
}
