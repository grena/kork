<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Helper;

use Doctrine\DBAL\Connection;

class DatabaseHelper
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function resetDatabase(): void
    {
        $this->resetTables();
    }

    private function resetTables(): void
    {
        $resetQuery = <<<SQL
            DELETE FROM `character`;
            DELETE FROM `game`;
            DELETE FROM `player`;
SQL;
        $this->sqlConnection->executeQuery($resetQuery);
    }
}
