<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Lobby;

use App\Application\Game\CreateGameCommand;
use App\Application\Game\CreateGameHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CreateGameAction extends Controller
{
    /** @var CreateGameHandler */
    private $createGameHandler;

    public function __construct(CreateGameHandler $createGameHandler)
    {
        $this->createGameHandler = $createGameHandler;
    }

    public function handle(): Response
    {
        $command = new CreateGameCommand();
        $command->playerId = $this->getUser()->getId();

        $violations = $this->get('validator')->validate($command);

        if ($violations->count() > 0) {
            return new JsonResponse($violations->get(0)->getMessage());
        }

        ($this->createGameHandler)($command);

        return $this->redirectToRoute('lobby');
    }
}
