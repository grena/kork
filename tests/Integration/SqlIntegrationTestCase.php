<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Domain\Model\Character;
use App\Domain\Model\Game;
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

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->playerRepository = self::$container->get('App\Infrastructure\Persistence\Sql\Player\SqlPlayerRepository');
        $this->gameRepository = self::$container->get('App\Infrastructure\Persistence\Sql\Game\SqlGameRepository');
        $this->characterRepository = self::$container->get('App\Infrastructure\Persistence\Sql\Character\SqlCharacterRepository');

        $databaseHelper = new DatabaseHelper(self::$container->get('database_connection'));
        $databaseHelper->resetDatabase();

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

        $gameWaiting = new Game();
        $gameWaiting->setId('game_waiting_for_players');
        $gameWaiting->setCreatedAt(new \DateTime('NOW'));
        $gameWaiting->setFinished(false);
        $gameWaiting->setStarted(false);
        $this->gameRepository->add($gameWaiting);

        $gameRunning = new Game();
        $gameRunning->setId('game_running');
        $gameRunning->setCreatedAt(new \DateTime('NOW'));
        $gameRunning->setFinished(false);
        $gameRunning->setStarted(true);
        $this->gameRepository->add($gameRunning);

        $gameFinished = new Game();
        $gameFinished->setId('game_finished');
        $gameFinished->setCreatedAt(new \DateTime('NOW'));
        $gameFinished->setFinished(true);
        $gameFinished->setStarted(true);
        $this->gameRepository->add($gameFinished);

        $grenaCharacterRunning = new Character();
        $grenaCharacterRunning->setId('grena_game_running');
        $grenaCharacterRunning->setGame($gameRunning);
        $grenaCharacterRunning->setPlayer($grena);
        $grenaCharacterRunning->setName('Docteur Slibard');
        $this->characterRepository->add($grenaCharacterRunning);

        $grenaCharacterFinished = new Character();
        $grenaCharacterFinished->setId('grena_game_finished');
        $grenaCharacterFinished->setGame($gameFinished);
        $grenaCharacterFinished->setPlayer($grena);
        $grenaCharacterFinished->setName('Captain Krapoulax');
        $this->characterRepository->add($grenaCharacterFinished);

        $bobCharacterRunning = new Character();
        $bobCharacterRunning->setId('bob_game_running');
        $bobCharacterRunning->setGame($gameRunning);
        $bobCharacterRunning->setPlayer($bob);
        $bobCharacterRunning->setName('Slurpy le Vicelard');
        $this->characterRepository->add($bobCharacterRunning);

        $leaverCharacterFinished = new Character();
        $leaverCharacterFinished->setId('leaver_game_finished');
        $leaverCharacterFinished->setGame($gameFinished);
        $leaverCharacterFinished->setPlayer($leaver);
        $leaverCharacterFinished->setName('Inspecteur Natchouki');
        $this->characterRepository->add($leaverCharacterFinished);

        $robertCharacterWaiting = new Character();
        $robertCharacterWaiting->setId('robert_game_waiting');
        $robertCharacterWaiting->setGame($gameWaiting);
        $robertCharacterWaiting->setPlayer($robert);
        $robertCharacterWaiting->setName('Sprootch');
        $this->characterRepository->add($robertCharacterWaiting);
    }
}
