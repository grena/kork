<?php

namespace Kork\Component\Game;

use Kork\Bundle\AppBundle\Doctrine\Repository\GameRepository;
use Kork\Bundle\AppBundle\Entity\Character;
use Kork\Bundle\AppBundle\Entity\Game;
use Kork\Bundle\AppBundle\Entity\User;
use Kork\Component\Character\CharacterGenerator;
use Kork\Component\Saver\SaverInterface;

class GameCreator
{
    /** @var SaverInterface */
    private $gameSaver;

    /** @var SaverInterface */
    private $characterSaver;

    /** @var GameRepository */
    private $gameRepository;

    /** @var CharacterGenerator */
    private $characterGenerator;

    /**
     * @param SaverInterface $gameSaver
     * @param SaverInterface $characterSaver
     */
    public function __construct(
        SaverInterface $gameSaver,
        SaverInterface $characterSaver,
        GameRepository $gameRepository,
        CharacterGenerator $characterGenerator
    ) {
        $this->gameSaver = $gameSaver;
        $this->characterSaver = $characterSaver;
        $this->gameRepository = $gameRepository;
        $this->characterGenerator = $characterGenerator;
    }

    public function createByUser(User $user)
    {
        // Create game
        $game = new Game();
        $game->setDateCreation(new \DateTime('now'));
        $game->setCurrentDay(1);
        $game->setGameSeed(rand());
        $this->gameSaver->save($game);

        // Create character
        $character = $this->characterGenerator->generate($game);
        $character->setUser($user);
        $this->characterSaver->save($character);
    }

    public function userJoinsByCode(User $user, string $code)
    {
        /** @var Game $game */
        $game = $this->gameRepository->find($code);

        if (null === $game) {
            throw new \LogicException(
                sprintf('Cannot join game with code "%s" as it does not exist', $code)
            );
        }

        // Create character
        $character = $this->characterGenerator->generate($game);
        $character->setUser($user);
        $this->characterSaver->save($character);
    }
}
