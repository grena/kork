<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Player;

use App\Domain\Query\Player\PlayerHasActiveCharacterInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlPlayerHasActiveCharacter implements PlayerHasActiveCharacterInterface
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function withPlayer(string $playerIdentifier): bool
    {
        $query = <<<SQL
        SELECT EXISTS (
            SELECT 1
            FROM `character` as c
            LEFT JOIN `game` as g
                ON c.game_id = g.id
            WHERE c.player_id = :playerId
            AND g.finished = false
        )
SQL;
        $statement = $this->sqlConnection->executeQuery($query, [
            'playerId' => $playerIdentifier
        ]);

        $platform = $this->sqlConnection->getDatabasePlatform();
        $result = $statement->fetchColumn();
        $hasActivePlayer = Type::getType(Type::BOOLEAN)->convertToPhpValue($result, $platform);

        return $hasActivePlayer;
    }
}
