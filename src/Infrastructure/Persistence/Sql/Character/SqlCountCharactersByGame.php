<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Character;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Character\CountCharactersByGameInterface;
use Doctrine\DBAL\Connection;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlCountCharactersByGame implements CountCharactersByGameInterface
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function withIdentifier(GameIdentifier $gameIdentifier): int
    {
        $query = <<<SQL
        SELECT COUNT(*)
        FROM `character`
        WHERE game_id = :gameId
SQL;
        $statement = $this->sqlConnection->executeQuery($query, [
            'gameId' => (string) $gameIdentifier
        ]);

        return intval($statement->fetchColumn());
    }
}
