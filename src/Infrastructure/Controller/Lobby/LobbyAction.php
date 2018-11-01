<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Lobby;

use App\Domain\Model\Game\Game;
use App\Domain\Query\Character\CharacterDetails;
use App\Domain\Query\Character\FindCharactersDetailsByGameInterface;
use App\Domain\Repository\GameRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class LobbyAction extends Controller
{
    /** @var GameRepositoryInterface */
    private $gameRepository;

    /** @var FindCharactersDetailsByGameInterface */
    private $charactersDetailsByGame;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        FindCharactersDetailsByGameInterface $charactersDetailsByGame
    ) {
        $this->gameRepository = $gameRepository;
        $this->charactersDetailsByGame = $charactersDetailsByGame;
    }

    public function handle(): Response
    {
        $player = $this->getUser();
        $currentGame = $this->gameRepository->findActiveForPlayer($player->getId());

        if (null === $currentGame) {
            return $this->render('lobby_out.html.twig');
        } else {
            if ($currentGame->isStarted()) {
                // REDIRECT TO PLAY
            }

            $characters = $this->charactersDetailsByGame->withIdentifier($currentGame->getId());
            $characters = array_map(function (CharacterDetails $character) {
                return $character->normalize();
            }, $characters);

            return $this->render('lobby_in.html.twig', [
                'characters' => $characters,
                'game' => $currentGame,
                'player_count_needed' => Game::NUMBER_OF_PLAYERS_REQUIRED_TO_START
            ]);
        }
    }
}
