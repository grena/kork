<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Sql\Game;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameCreatedAt;
use App\Domain\Model\Game\GameFinished;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Model\Game\GameStarted;
use App\Domain\Repository\GameNotFoundException;
use App\Tests\Integration\SqlIntegrationTestCase;

class SqlGameRepositoryTest extends SqlIntegrationTestCase
{
    /**
     * @test
     */
    public function it_adds_a_game_an_returns_it()
    {
        $game = Game::create(
            GameIdentifier::fromString('12345'),
            GameCreatedAt::fromString('2018-02-22 18:55:00'),
            GameStarted::fromBoolean(true),
            GameFinished::fromBoolean(false)
        );

        $this->gameRepository->add($game);

        $gameFound = $this->gameRepository->getByIdentifier(GameIdentifier::fromString('12345'));

        $this->assertEquals($game, $gameFound);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_no_game_has_been_found_with_a_given_identifier()
    {
        $identifier = GameIdentifier::fromString('unknown');
        $this->expectException(GameNotFoundException::class);

        $this->gameRepository->getByIdentifier($identifier);
    }
}
