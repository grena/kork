<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sql\Installation;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class SchemaCreator
{
    /** @var Connection */
    private $sqlConnection;

    public function __construct(Connection $sqlConnection)
    {
        $this->sqlConnection = $sqlConnection;
    }

    public function create()
    {
        $schema = $this->getSchema();
        $queries = $schema->toSql($this->sqlConnection->getDatabasePlatform());

        foreach ($queries as $query) {
            $this->sqlConnection->executeQuery($query);
        }
    }

    public function drop()
    {
        $schema = $this->getSchema();
        $queries = $schema->toDropSql($this->sqlConnection->getDatabasePlatform());

        foreach ($queries as $query) {
            $this->sqlConnection->executeQuery($query);
        }
    }

    private function getSchema(): Schema
    {
        $schema = new Schema();

        // GAME TABLE
        $gameTable = $schema->createTable('game');
        $gameTable->addColumn('id', Type::STRING, ['length' => 36]);
        $gameTable->addColumn('created_at', Type::DATETIME_IMMUTABLE, ['notnull' => true]);
        $gameTable->addColumn('started', Type::BOOLEAN, ['notnull' => true, 'default' => false]);
        $gameTable->addColumn('finished', Type::BOOLEAN, ['notnull' => true, 'default' => false]);

        $gameTable->setPrimaryKey(['id']);

        // CHARACTER TABLE
        $characterTable = $schema->createTable('character');
        $characterTable->addColumn('id', Type::STRING, ['length' => 36]);
        $characterTable->addColumn('game_id', Type::STRING, ['length' => 36, 'notnull' => true]);
        $characterTable->addColumn('player_id', Type::STRING, ['length' => 36, 'notnull' => true]);
        $characterTable->addColumn('name', Type::STRING, ['length' => 255, 'notnull' => true]);
        $characterTable->addColumn('picture', Type::STRING, ['length' => 255, 'notnull' => true]);

        $characterTable->addForeignKeyConstraint(
            $gameTable,
            ['game_id'],
            ['id'],
            ['onUpdate' => 'CASCADE']
        );

        // WILL USE ONCE PLAYER NOT TRACKED BY DOCTRINE
//        $characterTable->addForeignKeyConstraint(
//            'player',
//            ['player_id'],
//            ['id'],
//            ['onUpdate' => 'CASCADE']
//        );

        $characterTable->setPrimaryKey(['id']);

        return $schema;
    }
}
