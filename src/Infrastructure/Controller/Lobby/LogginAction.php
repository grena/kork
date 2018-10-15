<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Lobby;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class LogginAction extends Controller
{
    public function handle(): Response
    {
        return $this->render('login.html.twig');
    }
}
