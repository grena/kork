<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Lobby;

use App\Application\Player\PlayerJoinsGameCommand;
use App\Application\Player\PlayerJoinsGameHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class JoinGameAction extends Controller
{
    /** @var PlayerJoinsGameHandler */
    private $playerJoinsGameHandler;

    public function __construct(PlayerJoinsGameHandler $playerJoinsGameHandler)
    {
        $this->playerJoinsGameHandler = $playerJoinsGameHandler;
    }

    public function handle(string $gameId): Response
    {
        $command = new PlayerJoinsGameCommand();
        $command->playerId = $this->getUser()->getId();
        $command->gameId = $gameId;

        $violations = $this->get('validator')->validate($command);

        if ($violations->count() > 0) {
            return new JsonResponse($violations->get(0)->getMessage());
        }

        ($this->playerJoinsGameHandler)($command);

        return $this->redirectToRoute('lobby');
    }
}
