<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LobbyController extends Controller
{
    public function index()
    {
        return $this->redirectToRoute('lobby');
    }

    public function lobby()
    {
        return $this->render('lobby.html.twig');
    }

    public function login()
    {
        return $this->render('login.html.twig');
    }
}
