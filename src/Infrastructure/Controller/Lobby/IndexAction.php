<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Lobby;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class IndexAction extends AbstractController
{
    /**
     * TODO: Later, have eventually a real home page to explain the game, etc... For now, let's just redirect to lobby
     */
    public function handle(): Response
    {
        return $this->redirectToRoute('lobby');
    }
}
