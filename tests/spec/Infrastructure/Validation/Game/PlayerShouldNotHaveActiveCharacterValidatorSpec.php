<?php

declare(strict_types=1);

namespace spec\App\Infrastructure\Validation\Game;

use App\Application\Game\CreateGameCommand;
use App\Domain\Model\Player;
use App\Domain\Query\Player\PlayerHasActiveCharacterInterface;
use App\Domain\Repository\PlayerRepositoryInterface;
use App\Infrastructure\Validation\Game\PlayerShouldNotHaveActiveCharacter;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class PlayerShouldNotHaveActiveCharacterValidatorSpec extends ObjectBehavior
{
    function let(
        PlayerHasActiveCharacterInterface $hasActiveCharacter,
        PlayerRepositoryInterface $playerRepository,
        ExecutionContextInterface $context
    ) {
        $this->beConstructedWith($hasActiveCharacter, $playerRepository);
        $this->initialize($context);
    }

    function it_adds_a_violation_if_player_already_has_an_active_character(
        PlayerHasActiveCharacterInterface $hasActiveCharacter,
        PlayerRepositoryInterface $playerRepository,
        ExecutionContextInterface $context,
        CreateGameCommand $command,
        PlayerShouldNotHaveActiveCharacter $constraint,
        Player $player,
        ConstraintViolationBuilderInterface $violationBuilder
    ) {
        $command->playerId = '12345';
        $playerRepository->getById('12345')->willReturn($player);
        $hasActiveCharacter->withPlayer($player)->willReturn(true);

        $context->buildViolation(PlayerShouldNotHaveActiveCharacter::ERROR_MESSAGE)->willReturn($violationBuilder);
        $violationBuilder->addViolation()->shouldBeCalled();

        $this->validate($command, $constraint);
    }

    function it_does_nothing_if_player_does_not_have_an_active_character(
        PlayerHasActiveCharacterInterface $hasActiveCharacter,
        PlayerRepositoryInterface $playerRepository,
        ExecutionContextInterface $context,
        CreateGameCommand $command,
        PlayerShouldNotHaveActiveCharacter $constraint,
        Player $player
    ) {
        $command->playerId = '12345';
        $playerRepository->getById('12345')->willReturn($player);
        $hasActiveCharacter->withPlayer($player)->willReturn(false);

        $context->buildViolation(PlayerShouldNotHaveActiveCharacter::ERROR_MESSAGE)->shouldNotBeCalled();

        $this->validate($command, $constraint);
    }

    function it_throws_an_exception_if_it_is_not_the_good_constraint_type(
        CreateGameCommand $command,
        Constraint $constraint
    ) {
        $this->shouldThrow(UnexpectedTypeException::class)
            ->during('validate', [$command, $constraint]);
    }

    function it_throws_an_exception_if_it_is_not_the_good_command_type(
        PlayerShouldNotHaveActiveCharacter $constraint
    ) {
        $command = new \stdClass();

        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('validate', [$command, $constraint]);
    }
}
