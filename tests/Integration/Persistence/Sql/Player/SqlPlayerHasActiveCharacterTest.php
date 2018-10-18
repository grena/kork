<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Sql\Player;

use App\Infrastructure\Persistence\Sql\Player\SqlPlayerHasActiveCharacter;
use App\Tests\Integration\SqlIntegrationTestCase;

class SqlPlayerHasActiveCharacterTest extends SqlIntegrationTestCase
{
    /** @var SqlPlayerHasActiveCharacter */
    private $playerHasActiveCharacter;

    protected function setUp()
    {
        parent::setUp();

        $this->playerHasActiveCharacter = self::$container->get('App\Infrastructure\Persistence\Sql\Player\SqlPlayerHasActiveCharacter');
    }

    /**
     * @test
     */
    public function it_returns_false_if_the_player_has_no_character_at_all()
    {
        $player = $this->playerRepository->getByUsername('newbie');

        $hasActivePlayer = $this->playerHasActiveCharacter->withPlayer($player);
        $this->assertFalse($hasActivePlayer);
    }

    /**
     * @test
     */
    public function it_returns_false_if_the_player_has_none_of_its_characters_in_an_active_game()
    {
        $player = $this->playerRepository->getByUsername('leaver');

        $hasActivePlayer = $this->playerHasActiveCharacter->withPlayer($player);
        $this->assertFalse($hasActivePlayer);
    }

    /**
     * @test
     */
    public function it_returns_true_if_the_player_has_a_character_in_an_active_game()
    {
        $player = $this->playerRepository->getByUsername('grena');

        $hasActivePlayer = $this->playerHasActiveCharacter->withPlayer($player);
        $this->assertTrue($hasActivePlayer);
    }

    /**
     * @test
     */
    public function it_returns_true_if_the_player_has_a_character_in_an_game_waiting_for_player()
    {
        $player = $this->playerRepository->getByUsername('robert');

        $hasActivePlayer = $this->playerHasActiveCharacter->withPlayer($player);
        $this->assertTrue($hasActivePlayer);
    }
}
