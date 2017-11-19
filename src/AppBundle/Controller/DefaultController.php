<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request): Response
    {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('@App/default/index.html.twig');
        }

        if (null === $user->getCurrentCharacter()) {
            return $this->render('@App/default/lobby.html.twig');
        }

        return $this->redirectToRoute('play_game');
    }

    /**
     * @Route("/create-game", name="create_game")
     */
    public function createGameAction(Request $request): Response
    {
        $user = $this->getUser();

        if (null === $user->getCurrentCharacter()) {
            $this->get('kork.app_bundle.game.game_creator')->createWithUser($user);
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/play", name="play_game")
     */
    public function playGameAction(Request $request): Response
    {
        $user = $this->getUser();

        if (null === $user->getCurrentCharacter()) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('@App/default/play.html.twig');
    }
}
