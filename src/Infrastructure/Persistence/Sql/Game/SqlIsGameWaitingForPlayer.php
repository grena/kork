<?php

declare(strict_types=1);

/*
 * This file is part of the Akeneo PIM Enterprise Edition.
 *
 * (c) 2018 Akeneo SAS (http://www.akeneo.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Sql\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\IsGameWaitingForPlayerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SqlIsGameWaitingForPlayer implements IsGameWaitingForPlayerInterface
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
        SELECT EXISTS(
            SELECT *
            FROM `game`
            WHERE id = :gameId
            AND started = false
            AND finished = false
        )
SQL;
        $statement = $this->sqlConnection->executeQuery($query, [
            'gameId' => (string) $gameIdentifier
        ]);

        $result = $statement->fetchColumn();
        $platform = $this->sqlConnection->getDatabasePlatform();
        $isWaitingForPlayer = Type::getType(Type::BOOLEAN)->convertToPhpValue($result, $platform);

        return $isWaitingForPlayer;
    }
}
