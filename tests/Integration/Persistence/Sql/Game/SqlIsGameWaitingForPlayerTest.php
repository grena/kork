<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Sql\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Infrastructure\Persistence\Sql\Game\SqlGameExists;
use App\Tests\Integration\SqlIntegrationTestCase;

class SqlIsGameWaitingForPlayerTest extends SqlIntegrationTestCase
{
    /** @var SqlGameExists */
    private $query;

    protected function setUp()
    {
        parent::setUp();

        $this->query = self::$container->get('App\Infrastructure\Persistence\Sql\Game\SqlIsGameWaitingForPlayer');
    }

    /**
     * @test
     */
    public function it_tells_if_a_game_is_waiting_for_player()
    {
        $gameIdentifier = GameIdentifier::fromString('game_running');
        $this->assertFalse($this->query->withIdentifier($gameIdentifier));

        $gameIdentifier = GameIdentifier::fromString('game_waiting_for_players');
        $this->assertTrue($this->query->withIdentifier($gameIdentifier));
    }
}
