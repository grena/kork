<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Sql\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Infrastructure\Persistence\Sql\Game\SqlFindAllGamesWaitingForPlayer;
use App\Tests\Integration\SqlIntegrationTestCase;

class SqlFindAllGamesWaitingForPlayerTest extends SqlIntegrationTestCase
{
    /** @var SqlFindAllGamesWaitingForPlayer */
    private $query;

    protected function setUp()
    {
        parent::setUp();

        $this->query = self::$container->get('App\Infrastructure\Persistence\Sql\Game\SqlFindAllGamesWaitingForPlayer');
    }

    /**
     * @test
     */
    public function it_finds_all_games_waiting_for_player()
    {
        $expectedGames = [
            GameIdentifier::fromString('game_waiting_for_players')
        ];
        $gamesFound = ($this->query)();

        $this->assertContainsOnlyInstancesOf(GameIdentifier::class, $gamesFound);
        $this->assertEquals($expectedGames, $gamesFound);

        $this->databaseHelper->resetDatabase();

        $expectedGames = [];
        $gamesFound = ($this->query)();
        $this->assertEquals($expectedGames, $gamesFound);
    }
}
