<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Character;

use App\Domain\Model\Character;
use App\Domain\Repository\CharacterRepositoryInterface;
use Doctrine\DBAL\Connection;

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
                'id' => $character->getId(),
                'game_id' => $character->getGame()->getId(),
                'player_id' => $character->getPlayer()->getId(),
                'name' => $character->getName(),
            ]
        );

        if ($affectedRows > 1) {
            throw new \RuntimeException(
                sprintf('Expected to add one character, but %d rows were affected', $affectedRows)
            );
        }
    }

    // TODO: implement nextIdentifier method
}