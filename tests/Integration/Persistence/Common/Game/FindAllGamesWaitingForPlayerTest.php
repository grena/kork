<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Common\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\FindAllGamesWaitingForPlayerInterface;
use App\Tests\Integration\IntegrationTestCase;

class FindAllGamesWaitingForPlayerTest extends IntegrationTestCase
{
    /** @var FindAllGamesWaitingForPlayerInterface */
    private $query;

    protected function setUp()
    {
        parent::setUp();

        $this->query = self::$container->get('App\Domain\Query\Game\FindAllGamesWaitingForPlayerInterface');
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

        $this->resetFixtures();

        $expectedGames = [];
        $gamesFound = ($this->query)();
        $this->assertEquals($expectedGames, $gamesFound);
    }
}
