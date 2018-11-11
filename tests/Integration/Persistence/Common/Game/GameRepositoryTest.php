<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Common\Game;

use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Repository\GameNotFoundException;
use App\Tests\Integration\IntegrationTestCase;

class GameRepositoryTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_adds_a_game_an_returns_it()
    {
        $normalizedGame = [
            'id' => '12345',
            'created_at' => '2018-02-22 18:55:00',
            'started' => true,
            'finished' => false,
            'travel_start_at' => null,
            'travel_stop_at' => null,
        ];

        $game = Game::fromNormalized($normalizedGame);
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

    /**
     * @test
     */
    public function it_finds_the_active_game_the_player_has_an_character_in()
    {
        $playerIdentifier = 'grena-123';
        $gameRunning = Game::fromNormalized([
            'id' => 'game_running',
            'created_at' => '2018-10-01 19:00:00',
            'started' => true,
            'finished' => false,
            'travel_start_at' => null,
            'travel_stop_at' => null,
        ]);

        $foundGame = $this->gameRepository->findActiveForPlayer($playerIdentifier);
        $this->assertEquals($gameRunning, $foundGame);
    }

    /**
     * @test
     */
    public function it_returns_null_if_the_given_player_has_no_active_game()
    {
        $playerIdentifier = 'leaver-123';

        $foundGame = $this->gameRepository->findActiveForPlayer($playerIdentifier);
        $this->assertNull($foundGame);
    }

    /**
     * @test
     */
    public function it_updates_a_game()
    {
        $gameIdentifier = GameIdentifier::fromString('game_waiting_for_players');
        $game = $this->gameRepository->getByIdentifier($gameIdentifier);

        $game->start();
        $this->gameRepository->update($game);

        $gameFound = $this->gameRepository->getByIdentifier($gameIdentifier);

        $this->assertEquals($game, $gameFound);
    }
}
