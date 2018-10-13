<?php

namespace Kork\Component\Character;


use Kork\Bundle\AppBundle\Entity\Character;
use Kork\Bundle\AppBundle\Entity\Game;

class CharacterGenerator
{
    /** @var string */
    private $rootDir;

    public function __construct(
        string $rootDir
    ) {
        $this->rootDir = $rootDir;
    }

    public function generate(Game $game): Character
    {
        $availableNames = $this->getNames();

        if (null !== $game->getCharacters()) {
            $existingNames = $game->getCharacters()->map(function (Character $character) {
                return $character->getName();
            })->toArray();

            $availableNames = array_diff($availableNames, $existingNames);
        }

        shuffle($availableNames);

        $character = new Character();
        $character->setActive(true);
        $character->setName(current($availableNames));
        $character->setGame($game);
        $character->setWater(100);
        $character->setFood(100);
        $character->setHealth(100);

        return $character;
    }

    private function getNames(): array
    {
        $filename = sprintf('%s/../data/character_names.txt', $this->rootDir);

        return file($filename);
    }
}
