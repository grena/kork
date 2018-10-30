<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Character;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Character\CharacterDetails;
use App\Domain\Query\Character\FindCharactersDetailsByGameInterface;
use Doctrine\DBAL\Connection;
use PDO;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlFindCharactersDetailsByGame implements FindCharactersDetailsByGameInterface
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function withIdentifier(GameIdentifier $gameIdentifier): array
    {
        $query = <<<SQL
        SELECT c.name, c.picture, p.username, p.id
        FROM `character` as c
        LEFT JOIN `player` as p
            ON c.player_id = p.id
        WHERE game_id = :gameId
SQL;
        $statement = $this->sqlConnection->executeQuery($query, [
            'gameId' => (string) $gameIdentifier
        ]);

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $characterDetails = [];
        foreach ($results as $result) {
            $character = new CharacterDetails();
            $character->name = $result['name'];
            $character->picture = $result['picture'];
            $character->playerUsername = $result['username'];
            $character->playerIdentifier = $result['id'];

            $characterDetails[] = $character;
        }

        return $characterDetails;
    }
}
