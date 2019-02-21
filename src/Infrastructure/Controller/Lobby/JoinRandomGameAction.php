<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Lobby;

use App\Application\Player\PlayerJoinsRandomGameCommand;
use App\Application\Player\PlayerJoinsRandomGameHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class JoinRandomGameAction extends AbstractController
{
    /** @var PlayerJoinsRandomGameHandler */
    private $playerJoinsRandomGameHandler;

    public function __construct(PlayerJoinsRandomGameHandler $playerJoinsRandomGameHandler)
    {
        $this->playerJoinsRandomGameHandler = $playerJoinsRandomGameHandler;
    }

    public function handle(): Response
    {
        $command = new PlayerJoinsRandomGameCommand();
        $command->playerId = $this->getUser()->getId();

        $violations = $this->get('validator')->validate($command);

        if ($violations->count() > 0) {
            return new JsonResponse($violations->get(0)->getMessage());
        }

        ($this->playerJoinsRandomGameHandler)($command);

        return $this->redirectToRoute('lobby');
    }
}
