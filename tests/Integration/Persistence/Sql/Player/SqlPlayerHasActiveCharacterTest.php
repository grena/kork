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
        $hasActivePlayer = $this->playerHasActiveCharacter->withPlayer('newbie-123');
        $this->assertFalse($hasActivePlayer);
    }

    /**
     * @test
     */
    public function it_returns_false_if_the_player_has_none_of_its_characters_in_an_active_game()
    {
        $hasActivePlayer = $this->playerHasActiveCharacter->withPlayer('leaver-123');
        $this->assertFalse($hasActivePlayer);
    }

    /**
     * @test
     */
    public function it_returns_true_if_the_player_has_a_character_in_an_active_game()
    {
        $hasActivePlayer = $this->playerHasActiveCharacter->withPlayer('grena-123');
        $this->assertTrue($hasActivePlayer);
    }

    /**
     * @test
     */
    public function it_returns_true_if_the_player_has_a_character_in_an_game_waiting_for_player()
    {
        $hasActivePlayer = $this->playerHasActiveCharacter->withPlayer('robert-123');
        $this->assertTrue($hasActivePlayer);
    }
}
