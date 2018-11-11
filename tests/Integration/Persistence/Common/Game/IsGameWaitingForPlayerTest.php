<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Common\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\IsGameWaitingForPlayerInterface;
use App\Tests\Integration\IntegrationTestCase;

class IsGameWaitingForPlayerTest extends IntegrationTestCase
{
    /** @var IsGameWaitingForPlayerInterface */
    private $query;

    protected function setUp()
    {
        parent::setUp();

        $this->query = self::$container->get('App\Domain\Query\Game\IsGameWaitingForPlayerInterface');
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
