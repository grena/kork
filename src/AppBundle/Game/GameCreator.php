<?php

namespace AppBundle\Game;


use AppBundle\Doctrine\Repository\GameRepository;
use AppBundle\Doctrine\Saver\BaseSaver;
use AppBundle\Entity\Character;
use AppBundle\Entity\Game;
use AppBundle\Entity\User;

class GameCreator
{
    /** @var BaseSaver */
    private $gameSaver;

    /** @var BaseSaver */
    private $characterSaver;

    /** @var GameRepository */
    private $gameRepository;

    /**
     * @param BaseSaver $gameSaver
     * @param BaseSaver $characterSaver
     */
    public function __construct(BaseSaver $gameSaver, BaseSaver $characterSaver, GameRepository $gameRepository)
    {
        $this->gameSaver = $gameSaver;
        $this->characterSaver = $characterSaver;
        $this->gameRepository = $gameRepository;
    }

    public function createWithUser(User $user)
    {
        // Create game
        $game = new Game();
        $game->setDateCreation(new \DateTime('now'));
        $this->gameSaver->save($game);

        // Create character
        $character = new Character();
        $character->setUser($user);
        $character->setGame($game);
        $character->setActive(true);
        $character->setName('Grabulax');
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
        $character = new Character();
        $character->setUser($user);
        $character->setGame($game);
        $character->setActive(true);
        $character->setName('Grabulax');
        $this->characterSaver->save($character);
    }
}
