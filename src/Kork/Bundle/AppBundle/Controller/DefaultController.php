<?php

namespace Kork\Bundle\AppBundle\Controller;

use Kork\Bundle\AppBundle\Entity\Character;
use Kork\Bundle\AppBundle\Entity\Game;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 * @copyright Copyright (c) 2017, Mech Shrimp Studios.
 */
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
            $this->get('kork.component.game.game_creator')->createByUser($user);
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/join-game", name="join_game")
     */
    public function joinGameAction(Request $request): Response
    {
        $user = $this->getUser();

        if (null === $user->getCurrentCharacter()) {
            $this->get('kork.component.game.game_creator')->userJoinsByCode($user, $request->get('code'));
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

        $character = $user->getCurrentCharacter();

        /** @var Game $game */
        $game = $user->getCurrentCharacter()->getGame();
        $this->get('kork.component.game.game_generator')->generate($game);

        return $this->render('@App/default/play.html.twig', [
            'game' => $game,
            'character' => $character,
        ]);
    }
}
