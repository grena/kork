<?php

declare(strict_types=1);

namespace App\Tests\Integration;

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
use App\Infrastructure\Persistence\Sql\Character\SqlCharacterRepository;
use App\Infrastructure\Persistence\Sql\Game\SqlGameRepository;
use App\Infrastructure\Persistence\Sql\Player\SqlPlayerRepository;
use App\Tests\Integration\Persistence\Helper\DatabaseHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SqlIntegrationTestCase extends KernelTestCase
{
    /** @var SqlPlayerRepository */
    protected $playerRepository;

    /** @var SqlGameRepository */
    protected $gameRepository;

    /** @var SqlCharacterRepository */
    protected $characterRepository;

    /** @var DatabaseHelper */
    protected $databaseHelper;

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->playerRepository = self::$container->get('App\Infrastructure\Persistence\Sql\Player\SqlPlayerRepository');
        $this->gameRepository = self::$container->get('App\Infrastructure\Persistence\Sql\Game\SqlGameRepository');
        $this->characterRepository = self::$container->get('App\Infrastructure\Persistence\Sql\Character\SqlCharacterRepository');

        $this->databaseHelper = new DatabaseHelper(self::$container->get('database_connection'));
        $this->databaseHelper->resetDatabase();

        // TODO: Put in real fixtures manager
        $grena = new Player();
        $grena->setId('grena-123');
        $grena->setUsername('grena');
        $grena->setUsernameCanonical('grena');
        $grena->setEnabled(true);
        $this->playerRepository->add($grena);

        $newbie = new Player();
        $newbie->setId('newbie-123');
        $newbie->setUsername('newbie');
        $newbie->setUsernameCanonical('newbie');
        $newbie->setEnabled(true);
        $this->playerRepository->add($newbie);

        $bob = new Player();
        $bob->setId('bob-123');
        $bob->setUsername('bob');
        $bob->setUsernameCanonical('bob');
        $bob->setEnabled(true);
        $this->playerRepository->add($bob);

        $leaver = new Player();
        $leaver->setId('leaver-123');
        $leaver->setUsername('leaver');
        $leaver->setUsernameCanonical('leaver');
        $leaver->setEnabled(true);
        $this->playerRepository->add($leaver);

        $robert = new Player();
        $robert->setId('robert-123');
        $robert->setUsername('robert');
        $robert->setUsernameCanonical('robert');
        $robert->setEnabled(true);
        $this->playerRepository->add($robert);

        $gameWaiting = Game::create(
            GameIdentifier::fromString('game_waiting_for_players'),
            GameCreatedAt::now(),
            GameStarted::fromBoolean(false),
            GameFinished::fromBoolean(false)
        );
        $this->gameRepository->add($gameWaiting);

        $gameRunning = Game::create(
            GameIdentifier::fromString('game_running'),
            GameCreatedAt::fromString('2018-10-01 19:00:00'),
            GameStarted::fromBoolean(true),
            GameFinished::fromBoolean(false)
        );
        $this->gameRepository->add($gameRunning);

        $gameFinished = Game::create(
            GameIdentifier::fromString('game_finished'),
            GameCreatedAt::now(),
            GameStarted::fromBoolean(true),
            GameFinished::fromBoolean(true)
        );
        $this->gameRepository->add($gameFinished);

        $grenaCharacterRunning = Character::create(
            CharacterIdentifier::fromString('grena_game_running'),
            $gameRunning->getId(),
            $grena->getId(),
            CharacterName::fromString('Docteur Slibard'),
            CharacterPicture::fromString('img/male/slib.png')
        );
        $this->characterRepository->add($grenaCharacterRunning);

        $grenaCharacterFinished = Character::create(
            CharacterIdentifier::fromString('grena_game_finished'),
            $gameFinished->getId(),
            $grena->getId(),
            CharacterName::fromString('Captain Krapoulax'),
            CharacterPicture::fromString('img/other/krap.png')
        );
        $this->characterRepository->add($grenaCharacterFinished);

        $bobCharacterRunning = Character::create(
            CharacterIdentifier::fromString('bob_game_running'),
            $gameRunning->getId(),
            $bob->getId(),
            CharacterName::fromString('Slurpy le Vicelard'),
            CharacterPicture::fromString('img/other/slur.png')
        );
        $this->characterRepository->add($bobCharacterRunning);

        $leaverCharacterFinished = Character::create(
            CharacterIdentifier::fromString('leaver_game_finished'),
            $gameFinished->getId(),
            $leaver->getId(),
            CharacterName::fromString('Inspecteur Natchouki'),
            CharacterPicture::fromString('img/male/natch.png')
        );
        $this->characterRepository->add($leaverCharacterFinished);

        $robertCharacterWaiting = Character::create(
            CharacterIdentifier::fromString('robert_game_waiting'),
            $gameWaiting->getId(),
            $robert->getId(),
            CharacterName::fromString('Sprootch'),
            CharacterPicture::fromString('img/other/sproo.png')
        );
        $this->characterRepository->add($robertCharacterWaiting);
    }
}
