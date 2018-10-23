<?php

declare(strict_types=1);

namespace spec\App\Application\Player;

use App\Application\Player\PlayerJoinsRandomGameCommand;
use App\Domain\Generator\Character\CharacterGeneratorInterface;
use App\Domain\Model\Character\Character;
use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\FindAllGamesWaitingForPlayerInterface;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\GameRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PlayerJoinsRandomGameHandlerSpec extends ObjectBehavior
{
    function let(
        FindAllGamesWaitingForPlayerInterface $findAllGamesWaitingForPlayer,
        CharacterGeneratorInterface $characterGenerator,
        GameRepositoryInterface $gameRepository,
        CharacterRepositoryInterface $characterRepository
    ) {
        $this->beConstructedWith(
            $findAllGamesWaitingForPlayer,
            $characterGenerator,
            $gameRepository,
            $characterRepository
        );
    }

    function it_creates_a_character_for_the_player_in_an_available_game(
        FindAllGamesWaitingForPlayerInterface $findAllGamesWaitingForPlayer,
        CharacterGeneratorInterface $characterGenerator,
        CharacterRepositoryInterface $characterRepository,
        GameIdentifier $availableGameIdentifier,
        Character $character
    ) {
        $command = new PlayerJoinsRandomGameCommand();
        $command->playerId = 'grena-123';

        $findAllGamesWaitingForPlayer->__invoke()->willReturn([
            $availableGameIdentifier
        ]);

        $characterGenerator->forGameAndPlayer($availableGameIdentifier, 'grena-123')->willReturn($character);
        $characterRepository->add($character)->shouldBeCalled();
    }

    function it_creates_a_character_for_the_player_in_an_new_game(
        FindAllGamesWaitingForPlayerInterface $findAllGamesWaitingForPlayer,
        CharacterGeneratorInterface $characterGenerator,
        GameRepositoryInterface $gameRepository,
        CharacterRepositoryInterface $characterRepository,
        GameIdentifier $newlyCreatedGameIdentifier,
        Character $character
    ) {
        $command = new PlayerJoinsRandomGameCommand();
        $command->playerId = 'grena-123';

        $findAllGamesWaitingForPlayer->__invoke()->willReturn([]);

        $gameRepository->nextIdentifier()->willReturn($newlyCreatedGameIdentifier);
        $gameRepository->add(Argument::type(Game::class))->shouldBeCalled();

        $characterGenerator->forGameAndPlayer($newlyCreatedGameIdentifier, 'grena-123')->willReturn($character);
        $characterRepository->add($character)->shouldBeCalled();
    }
}
