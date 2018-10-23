<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Lobby;

use App\Domain\Repository\CharacterRepositoryInterface;
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

    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        CharacterRepositoryInterface $characterRepository
    ) {
        $this->gameRepository = $gameRepository;
        $this->characterRepository = $characterRepository;
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

            $characters = $this->characterRepository->findAllByGame($currentGame->getId());

            return $this->render('lobby_in.html.twig', ['characters' => $characters]);
        }
    }
}
