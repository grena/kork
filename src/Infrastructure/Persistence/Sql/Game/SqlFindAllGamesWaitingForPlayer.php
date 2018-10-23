<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Game;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\FindAllGamesWaitingForPlayerInterface;
use Doctrine\DBAL\Connection;
use PDO;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlFindAllGamesWaitingForPlayer implements FindAllGamesWaitingForPlayerInterface
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    /**
     * @return GameIdentifier[]
     */
    public function __invoke(): array
    {
        $query = <<<SQL
        SELECT g.id as gameId, COUNT(c.id) as nbPlayers
        FROM `game` as g
        LEFT JOIN `character` as c
            ON g.id = c.game_id
        WHERE g.started = false
        AND g.finished = false
        GROUP BY g.id
        HAVING nbPlayers < :requiredNumberOfPlayers
SQL;
        $statement = $this->sqlConnection->executeQuery($query, [
            'requiredNumberOfPlayers' => Game::NUMBER_OF_PLAYERS_REQUIRED_TO_START
        ]);

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $gameIdentifiers = [];
        foreach ($results as $result) {
            $gameIdentifiers[] = GameIdentifier::fromString($result['gameId']);
        }

        return $gameIdentifiers;
    }
}
