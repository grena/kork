<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Game;

use App\Application\Game\CreateGameCommand;
use App\Application\Game\CreateGameHandler;
use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterIdentifier;
use App\Domain\Model\Character\CharacterName;
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

class CreateGameTest extends FakeIntegrationTestCase
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    /** @var CreateGameHandler */
    private $createGameHandler;

    /** @var ValidatorInterface */
    private $validator;

    /** @var PlayerRepositoryInterface */
    private $playerRepository;

    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->createGameHandler = self::$container->get('App\Application\Game\CreateGameHandler');
        $this->gameRepository = self::$container->get('App\Domain\Repository\GameRepositoryInterface');
        $this->playerRepository = self::$container->get('App\Domain\Repository\PlayerRepositoryInterface');
        $this->characterRepository = self::$container->get('App\Domain\Repository\CharacterRepositoryInterface');
        $this->validator = self::$container->get('validator');
    }

    /**
     * @test
     */
    public function a_game_can_be_created_by_a_player()
    {
        $player = new Player();
        $player->setId('grena-12345');
        $player->setUsername('grena');
        $player->setUsernameCanonical('grena');
        $player->setEnabled(true);
        $this->playerRepository->add($player);

        $command = new CreateGameCommand();
        $command->playerId = 'grena-12345';

        $violations = $this->validator->validate($command);

        if ($violations->count() > 0) {
            throw new \Exception(
                sprintf(
                    'Game creation command not valid: "%s"',
                    current($violations)->getMessage()
                )
            );
        }

        ($this->createGameHandler)($command);

        // Assert the game has been created
        $createdGame = $this->gameRepository->getByIdentifier(GameIdentifier::fromString('0'));
        $this->assertInstanceOf(Game::class, $createdGame);
    }

    /**
     * @test
     */
    public function a_player_cannot_create_a_game_if_he_already_has_an_active_character()
    {
        $game = Game::create(
            GameIdentifier::fromString('game_running'),
            GameCreatedAt::now(),
            GameStarted::fromBoolean(true),
            GameFinished::fromBoolean(false)
        );
        $this->gameRepository->add($game);

        $player = new Player();
        $player->setId('grena-12345');
        $player->setUsername('grena');
        $player->setUsernameCanonical('grena');
        $player->setEnabled(true);
        $this->playerRepository->add($player);

        $character = Character::create(
            CharacterIdentifier::fromString('bob'),
            $game,
            $player,
            CharacterName::fromString('bob')
        );
        $this->characterRepository->add($character);

        $command = new CreateGameCommand();
        $command->playerId = 'grena-12345';

        $violations = $this->validator->validate($command);

        // Assert violation because player has active character
        $this->assertGreaterThan(0, $violations->count());

        // Assert no more game is created
        $this->expectException(GameNotFoundException::class);
        $this->gameRepository->getByIdentifier(GameIdentifier::fromString('1'));
    }
}
