<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Game;

use App\Application\Player\PlayerJoinsGameCommand;
use App\Application\Player\PlayerJoinsGameHandler;
use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterIdentifier;
use App\Domain\Model\Character\CharacterName;
use App\Domain\Model\Character\CharacterPicture;
use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Model\Player;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\GameNotFoundException;
use App\Domain\Repository\GameRepositoryInterface;
use App\Domain\Repository\PlayerRepositoryInterface;
use App\Tests\Acceptance\FakeIntegrationTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PlayerJoinsGameTest extends FakeIntegrationTestCase
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    /** @var PlayerJoinsGameHandler */
    private $playerJoinsGameHandler;

    /** @var ValidatorInterface */
    private $validator;

    /** @var PlayerRepositoryInterface */
    private $playerRepository;

    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->playerJoinsGameHandler = self::$container->get('App\Application\Player\PlayerJoinsGameHandler');
        $this->gameRepository = self::$container->get('App\Domain\Repository\GameRepositoryInterface');
        $this->playerRepository = self::$container->get('App\Domain\Repository\PlayerRepositoryInterface');
        $this->characterRepository = self::$container->get('App\Domain\Repository\CharacterRepositoryInterface');
        $this->validator = self::$container->get('validator');
    }

    /**
     * @test
     */
    public function a_player_can_join_an_available_game_waiting_for_players_through_a_game_id()
    {
        $player = $this->createAndGetPlayer();

        $waitingGame = Game::createNew(GameIdentifier::fromString('game_waiting_for_players'));
        $this->gameRepository->add($waitingGame);

        $command = new PlayerJoinsGameCommand();
        $command->playerId = $player->getId();
        $command->gameId = 'game_waiting_for_players';

        $violations = $this->validator->validate($command);

        // Assert no violation
        $this->assertSame(0, $violations->count());

        ($this->playerJoinsGameHandler)($command);

        // Assert the character has been created and linked to player & game
        $characters = $this->characterRepository->findAllByGame(GameIdentifier::fromString('game_waiting_for_players'));
        $this->assertCount(1, $characters);

        $character = current($characters);
        $this->assertEquals($player->getId(), $character->getPlayerIdentifier());
        $this->assertEquals($waitingGame->getId(), $character->getGameIdentifier());
    }

    /**
     * @test
     */
    public function a_player_cannot_join_a_game_if_this_game_is_not_waiting_for_player()
    {
        $player = $this->createAndGetPlayer();

        $runningGame = Game::createNew(GameIdentifier::fromString('game_running'));
        $runningGame->start();
        $this->gameRepository->add($runningGame);

        $command = new PlayerJoinsGameCommand();
        $command->playerId = $player->getId();
        $command->gameId = 'game_running';

        $violations = $this->validator->validate($command);

        // Assert violation because game is not waiting for players
        $this->assertGreaterThan(0, $violations->count());

        // Assert no character is created in the game waiting for players
        $characters = $this->characterRepository->findAllByGame(GameIdentifier::fromString('game_running'));
        $this->assertCount(0, $characters);
    }

    /**
     * @test
     */
    public function a_player_cannot_join_a_game_if_this_game_is_already_full()
    {
        $player = $this->createAndGetPlayer();

        $availableButFullGame = Game::createNew(GameIdentifier::fromString('game_waiting_for_player_full'));
        $this->gameRepository->add($availableButFullGame);

        for ($i = 0; $i < 5; $i++) {
            $char = Character::create(
                CharacterIdentifier::fromString((string) $i),
                $availableButFullGame->getId(),
                sprintf('player_%s', $i),
                CharacterName::fromString((string) $i),
                CharacterPicture::fromString((string) $i)
            );
            $this->characterRepository->add($char);
        }

        $command = new PlayerJoinsGameCommand();
        $command->playerId = $player->getId();
        $command->gameId = 'game_waiting_for_player_full';

        $violations = $this->validator->validate($command);

        // Assert violation because game is full
        $this->assertGreaterThan(0, $violations->count());

        // Assert no character is created in the game
        $characters = $this->characterRepository->findAllByGame(
            GameIdentifier::fromString('game_waiting_for_player_full')
        );
        $this->assertCount(5, $characters);
    }

    /**
     * @test
     */
    public function a_player_cannot_join_a_non_existing_game()
    {
        $player = $this->createAndGetPlayer();

        $command = new PlayerJoinsGameCommand();
        $command->playerId = $player->getId();
        $command->gameId = 'unknown';

        $violations = $this->validator->validate($command);

        // Assert violation because game doesn't exist
        $this->assertGreaterThan(0, $violations->count());

        // Assert no game has been created
        $this->expectException(GameNotFoundException::class);
        $this->gameRepository->getByIdentifier(GameIdentifier::fromString('unknown'));
    }

    /**
     * @test
     */
    public function a_player_cannot_join_a_game_if_he_already_has_an_active_character()
    {
        $player = $this->createAndGetPlayer();

        $runningGame = Game::createNew(GameIdentifier::fromString('game_running'));
        $runningGame->start();
        $this->gameRepository->add($runningGame);

        $waitingGame = Game::createNew(GameIdentifier::fromString('game_waiting_for_players'));
        $this->gameRepository->add($waitingGame);

        $character = Character::create(
            CharacterIdentifier::fromString('bob'),
            $runningGame->getId(),
            $player->getId(),
            CharacterName::fromString('bob'),
            CharacterPicture::fromString('img/male/bob.png')
        );
        $this->characterRepository->add($character);

        $command = new PlayerJoinsGameCommand();
        $command->playerId = $player->getId();
        $command->gameId = 'game_waiting_for_players';

        $violations = $this->validator->validate($command);

        // Assert violation because player has active character
        $this->assertGreaterThan(0, $violations->count());

        // Assert no character is created in the game waiting for players
        $charactersWaiting = $this->characterRepository->findAllByGame(GameIdentifier::fromString('game_waiting_for_players'));
        $this->assertCount(0, $charactersWaiting);
    }

    private function createAndGetPlayer(): Player
    {
        $player = new Player();
        $player->setId('grena-12345');
        $player->setUsername('grena');
        $player->setUsernameCanonical('grena');
        $player->setEnabled(true);
        $this->playerRepository->add($player);

        return $player;
    }
}
