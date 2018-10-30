<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Character;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Character\CharacterDetails;
use App\Domain\Query\Character\FindCharactersDetailsByGameInterface;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\PlayerRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class InMemoryFindCharactersDetailsByGame implements FindCharactersDetailsByGameInterface
{
    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    /** @var PlayerRepositoryInterface */
    private $playerRepository;

    public function __construct(
        CharacterRepositoryInterface $characterRepository,
        PlayerRepositoryInterface $playerRepository
    ) {
        $this->characterRepository = $characterRepository;
        $this->playerRepository = $playerRepository;
    }

    public function withIdentifier(GameIdentifier $gameIdentifier): array
    {
        $charactersDetails = [];
        $characters = $this->characterRepository->findAllByGame($gameIdentifier);

        foreach ($characters as $character) {
            $player = $this->playerRepository->getById($character->getPlayerIdentifier());

            $characterDetails = new CharacterDetails();
            $characterDetails->name = $character->getName();
            $characterDetails->picture = $character->getPicture();
            $characterDetails->playerIdentifier = $player->getId();
            $characterDetails->playerUsername = $player->getUsername();

            $charactersDetails[] = $characterDetails;
        }

        return $charactersDetails;
    }
}
