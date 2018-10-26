<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\GameExistsInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use PDO;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlGameExists implements GameExistsInterface
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function withIdentifier(GameIdentifier $gameIdentifier): bool
    {
        $query = <<<SQL
        SELECT EXISTS (
            SELECT 1
            FROM `game`
            WHERE id = :gameId
        )
SQL;
        $statement = $this->sqlConnection->executeQuery($query, [
            'gameId' => (string) $gameIdentifier
        ]);

        $result = $statement->fetchColumn();
        $platform = $this->sqlConnection->getDatabasePlatform();
        $gameExists = Type::getType(Type::BOOLEAN)->convertToPhpValue($result, $platform);

        return $gameExists;
    }
}
