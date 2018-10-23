<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Game;

use App\Application\Player\PlayerJoinsRandomGameCommand;
use App\Application\Player\PlayerJoinsRandomGameHandler;
use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterIdentifier;
use App\Domain\Model\Character\CharacterName;
use App\Domain\Model\Character\CharacterPicture;
use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameCreatedAt;
use App\Domain\Model\Game\GameFinished;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Model\Game\GameStarted;
use App\Domain\Model\Player;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\GameNotFoundException;
use App\Domain\Repository\GameRepositoryInterface;
use App\Domain\Repository\PlayerRepositoryInterface;
use App\Tests\Acceptance\FakeIntegrationTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PlayerJoinsRandomGameTest extends FakeIntegrationTestCase
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    /** @var PlayerJoinsRandomGameHandler */
    private $playerJoinsRandomGameHandler;

    /** @var ValidatorInterface */
    private $validator;

    /** @var PlayerRepositoryInterface */
    private $playerRepository;

    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->playerJoinsRandomGameHandler = self::$container->get('App\Application\Player\PlayerJoinsRandomGameHandler');
        $this->gameRepository = self::$container->get('App\Domain\Repository\GameRepositoryInterface');
        $this->playerRepository = self::$container->get('App\Domain\Repository\PlayerRepositoryInterface');
        $this->characterRepository = self::$container->get('App\Domain\Repository\CharacterRepositoryInterface');
        $this->validator = self::$container->get('validator');
    }

    /**
     * @test
     */
    public function a_player_can_joins_a_random_available_game_waiting_for_player()
    {
        $player = new Player();
        $player->setId('grena-12345');
        $player->setUsername('grena');
        $player->setUsernameCanonical('grena');
        $player->setEnabled(true);
        $this->playerRepository->add($player);

        $unavailableGame = Game::create(
            GameIdentifier::fromString('game_running'),
            GameCreatedAt::fromString('2018-01-01 15:00:00'),
            GameStarted::fromBoolean(true),
            GameFinished::fromBoolean(false)
        );

        $availableGame = Game::create(
            GameIdentifier::fromString('game_waiting_for_player'),
            GameCreatedAt::fromString('2018-10-24 15:00:00'),
            GameStarted::fromBoolean(false),
            GameFinished::fromBoolean(false)
        );

        $availableButFullGame = Game::create(
            GameIdentifier::fromString('game_waiting_for_player_full'),
            GameCreatedAt::fromString('2018-10-24 09:00:00'),
            GameStarted::fromBoolean(false),
            GameFinished::fromBoolean(false)
        );

        $this->gameRepository->add($unavailableGame);
        $this->gameRepository->add($availableGame);
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

        $command = new PlayerJoinsRandomGameCommand();
        $command->playerId = 'grena-12345';

        $violations = $this->validator->validate($command);

        if ($violations->count() > 0) {
            throw new \Exception(
                sprintf(
                    'Player joins random game command not valid: "%s"',
                    current($violations)->getMessage()
                )
            );
        }

        ($this->playerJoinsRandomGameHandler)($command);

        // Assert no more game has been created
        $games = $this->gameRepository->games;
        $this->assertCount(3, $games);

        // Assert the character has been created
        $characters = $this->characterRepository->findAllByGame(GameIdentifier::fromString('game_waiting_for_player'));
        $this->assertCount(1, $characters);
    }

    /**
     * @test
     */
    public function if_no_game_is_available_then_a_new_game_is_created_and_the_player_joins_it()
    {
        $player = new Player();
        $player->setId('grena-12345');
        $player->setUsername('grena');
        $player->setUsernameCanonical('grena');
        $player->setEnabled(true);
        $this->playerRepository->add($player);

        $unavailableGame = Game::create(
            GameIdentifier::fromString('game_running'),
            GameCreatedAt::fromString('2018-01-01 15:00:00'),
            GameStarted::fromBoolean(true),
            GameFinished::fromBoolean(false)
        );

        $availableButFullGame = Game::create(
            GameIdentifier::fromString('game_waiting_for_player_full'),
            GameCreatedAt::fromString('2018-10-24 09:00:00'),
            GameStarted::fromBoolean(false),
            GameFinished::fromBoolean(false)
        );

        $this->gameRepository->add($unavailableGame);
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

        $command = new PlayerJoinsRandomGameCommand();
        $command->playerId = 'grena-12345';

        $violations = $this->validator->validate($command);

        if ($violations->count() > 0) {
            throw new \Exception(
                sprintf(
                    'Player joins random game command not valid: "%s"',
                    current($violations)->getMessage()
                )
            );
        }

        ($this->playerJoinsRandomGameHandler)($command);

        // Assert a new game has been created
        $games = $this->gameRepository->games;
        $this->assertCount(3, $games);

        // Assert the character has been created in the new game
        $characters = $this->characterRepository->findAllByGame(GameIdentifier::fromString('2'));
        $this->assertCount(1, $characters);
    }

    /**
     * @test
     */
    public function a_player_cannot_join_a_game_if_he_already_has_an_active_character()
    {
        $player = new Player();
        $player->setId('grena-12345');
        $player->setUsername('grena');
        $player->setUsernameCanonical('grena');
        $player->setEnabled(true);
        $this->playerRepository->add($player);

        $runningGame = Game::create(
            GameIdentifier::fromString('game_running'),
            GameCreatedAt::fromString('2018-01-01 15:00:00'),
            GameStarted::fromBoolean(true),
            GameFinished::fromBoolean(false)
        );
        $this->gameRepository->add($runningGame);

        $character = Character::create(
            CharacterIdentifier::fromString('bob'),
            $runningGame->getId(),
            $player->getId(),
            CharacterName::fromString('bob'),
            CharacterPicture::fromString('img/male/bob.png')
        );
        $this->characterRepository->add($character);

        $command = new PlayerJoinsRandomGameCommand();
        $command->playerId = 'grena-12345';

        $violations = $this->validator->validate($command);

        // Assert violation because player has active character
        $this->assertGreaterThan(0, $violations->count());

        // Assert no more game is created
        $this->expectException(GameNotFoundException::class);
        $this->gameRepository->getByIdentifier(GameIdentifier::fromString('1'));
    }
}
