<?php

declare(strict_types=1);

namespace spec\App\Application\Event\Handler;

use App\Domain\Event\Game\PlayerJoinedGameEvent;
use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Model\Game\TravelStartAt;
use App\Domain\Model\Game\TravelStopAt;
use App\Domain\Query\Character\CountCharactersByGameInterface;
use App\Domain\Repository\GameRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StartGameHandlerSpec extends ObjectBehavior
{
    function  let(
        GameRepositoryInterface $gameRepository,
        CountCharactersByGameInterface $charactersByGame
    ) {
        $this->beConstructedWith($gameRepository, $charactersByGame);
    }

    function it_supports_some_events(PlayerJoinedGameEvent $event)
    {
        $this->supports($event)->shouldReturn(true);
    }

    function it_starts_the_game_if_enough_players_are_in_the_game(
        GameRepositoryInterface $gameRepository,
        CountCharactersByGameInterface $charactersByGame,
        PlayerJoinedGameEvent $event,
        GameIdentifier $gameIdentifier,
        Game $game
    ) {
        $event->getGameIdentifier()->willReturn($gameIdentifier);
        $charactersByGame->withIdentifier($gameIdentifier)->willReturn(Game::NUMBER_OF_PLAYERS_REQUIRED_TO_START);

        $gameRepository->getByIdentifier($gameIdentifier)->willReturn($game);

        // We should start the game and set the travel date time
        $game->start()->shouldBeCalled();
        $game->setTravelStartAt(Argument::type(TravelStartAt::class))->shouldBeCalled();
        $game->setTravelStopAt(Argument::type(TravelStopAt::class))->shouldBeCalled();
        $gameRepository->update($game)->shouldBeCalled();

        $this->handle($event);
    }

    function it_does_nothing_if_there_is_not_enough_player_to_start_the_game(
        GameRepositoryInterface $gameRepository,
        CountCharactersByGameInterface $charactersByGame,
        PlayerJoinedGameEvent $event,
        GameIdentifier $gameIdentifier
    ) {
        $event->getGameIdentifier()->willReturn($gameIdentifier);
        $charactersByGame->withIdentifier($gameIdentifier)->willReturn(
            Game::NUMBER_OF_PLAYERS_REQUIRED_TO_START - 1
        );

        $gameRepository->getByIdentifier($gameIdentifier)->shouldNotBeCalled();
    }
}
