<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LobbyController extends Controller
{
    public function index()
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('loggy');
        }

        return $this->redirectToRoute('lobby');
    }

    public function lobby()
    {
        return $this->render('lobby.html.twig', ['user' => $this->getUser()]);
    }

    public function login()
    {
        return $this->render('login.html.twig');
    }
}
