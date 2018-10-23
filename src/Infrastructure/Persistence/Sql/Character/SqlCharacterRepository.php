<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Character;

use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterIdentifier;
use App\Domain\Model\Character\CharacterName;
use App\Domain\Model\Character\CharacterPicture;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Repository\CharacterRepositoryInterface;
use Doctrine\DBAL\Connection;
use PDO;
use Ramsey\Uuid\Uuid;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlCharacterRepository implements CharacterRepositoryInterface
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function add(Character $character): void
    {
        $insert = <<<SQL
        INSERT INTO `character`
            (id, game_id, player_id, name)
        VALUES 
            (:id, :game_id, :player_id, :name);
SQL;
        $affectedRows = $this->sqlConnection->executeUpdate(
            $insert,
            [
                'id' => (string) $character->getId(),
                'game_id' => (string) $character->getGame()->getId(),
                'player_id' => (string) $character->getPlayer()->getId(),
                'name' => (string) $character->getName(),
            ]
        );

        if ($affectedRows > 1) {
            throw new \RuntimeException(
                sprintf('Expected to add one character, but %d rows were affected', $affectedRows)
            );
        }
    }

    public function nextIdentifier(): CharacterIdentifier
    {
        return CharacterIdentifier::fromString(
            Uuid::uuid4()->toString()
        );
    }

    /**
     * @return Character[]
     */
    public function findAllByGame(GameIdentifier $gameIdentifier): array
    {
        $fetch = <<<SQL
        SELECT *
        FROM `character`
        WHERE game_id = :gameId;
SQL;
        $statement = $this->sqlConnection->executeQuery(
            $fetch,
            ['gameId' => (string) $gameIdentifier]
        );

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $characters = [];
        foreach ($results as $result) {
            $characters[] = $this->hydrateCharacter($result);
        }

        return $characters;
    }

    private function hydrateCharacter(array $result): Character
    {
        return Character::create(
            CharacterIdentifier::fromString($result['id']),
            GameIdentifier::fromString($result['game_id']),
            (string) $result['player_id'],
            CharacterName::fromString($result['name']),
            CharacterPicture::fromString($result['picture'])
        );
    }
}
