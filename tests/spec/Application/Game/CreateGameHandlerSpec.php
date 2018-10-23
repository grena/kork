<?php

declare(strict_types=1);

namespace spec\App\Application\Game;

use App\Application\Game\CreateGameCommand;
use App\Domain\Generator\Character\CharacterGeneratorInterface;
use App\Domain\Model\Character\Character;
use App\Domain\Model\Game\Game;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Repository\CharacterRepositoryInterface;
use App\Domain\Repository\GameRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateGameHandlerSpec extends ObjectBehavior
{
    function let(
        GameRepositoryInterface $gameRepository,
        CharacterRepositoryInterface $characterRepository,
        CharacterGeneratorInterface $characterGenerator
    ) {
        $this->beConstructedWith(
            $gameRepository,
            $characterRepository,
            $characterGenerator
        );
    }

    function it_creates_a_game_along_with_a_character_for_the_player(
        GameRepositoryInterface $gameRepository,
        CharacterRepositoryInterface $characterRepository,
        CharacterGeneratorInterface $characterGenerator,
        GameIdentifier $gameIdentifier,
        Character $character
    ) {
        $command = new CreateGameCommand();
        $command->playerId = 'grena';

        $gameRepository->nextIdentifier()->willReturn($gameIdentifier);
        $gameRepository->add(Argument::type(Game::class))->shouldBeCalled();

        $characterGenerator->forGameAndPlayer(
            $gameIdentifier,
            'grena'
        )->willReturn($character);

        $characterRepository->add($character)->shouldBeCalled();

        $this->__invoke($command);
    }
}
