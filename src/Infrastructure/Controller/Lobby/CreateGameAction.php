<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Lobby;

use App\Application\Game\CreateGameCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CreateGameAction extends Controller
{
    public function handle(): Response
    {
        $command = new CreateGameCommand();
        $command->player = $this->getUser();

        $violations = $this->get('validator')->validate($command);

        if ($violations->count() > 0) {
            return new JsonResponse($violations->get(0)->getMessage());
        }

        return new Response('Game created');
    }
}
