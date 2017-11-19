<?php

namespace AppBundle\Game;


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

    /**
     * @param BaseSaver $gameSaver
     * @param BaseSaver $characterSaver
     */
    public function __construct(BaseSaver $gameSaver, BaseSaver $characterSaver)
    {
        $this->gameSaver = $gameSaver;
        $this->characterSaver = $characterSaver;
    }

    public function createWithUser(User $user)
    {
        // Create character
        $character = new Character();
        $character->setUser($user);
        $character->setActive(true);
        $character->setName('Grabulax');
        $this->characterSaver->save($character);

        // Create game
        $game = new Game();
        $game->addCharacter($character);
        $game->setDateCreation(new \DateTime('now'));
        $this->gameSaver->save($game);
    }
}
