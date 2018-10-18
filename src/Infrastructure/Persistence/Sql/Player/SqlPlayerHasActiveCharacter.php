<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Player;

use App\Domain\Model\Player;
use App\Domain\Query\Player\PlayerHasActiveCharacterInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use PDO;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PlayerHasActiveCharacter implements PlayerHasActiveCharacterInterface
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function withPlayer(Player $player): bool
    {
        $query = <<<SQL
        SELECT EXISTS (
            SELECT 1
            FROM `character`
            WHERE player_id = :playerId
            AND game_id IN (
                SELECT id
                FROM game
                WHERE finished = false
            )
        ) as has_active_character
SQL;
        $statement = $this->sqlConnection->executeQuery($query, [
            'playerId' => (string) $player->getId()
        ]);

        $platform = $this->sqlConnection->getDatabasePlatform();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $hasActivePlayer = Type::getType(Type::BOOLEAN)->convertToPhpValue($result['has_active_character'], $platform);

        return $hasActivePlayer;
    }
}
