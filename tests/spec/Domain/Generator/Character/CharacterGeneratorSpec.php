<?php

declare(strict_types=1);

namespace spec\App\Domain\Generator\Character;

use App\Domain\Generator\Character\NoNameAvailableException;
use App\Domain\Generator\Character\NoPictureAvailableException;
use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterIdentifier;
use App\Domain\Model\Character\CharacterName;
use App\Domain\Model\Character\CharacterPicture;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Provider\Character\NameProviderInterface;
use App\Domain\Provider\Character\PictureProviderInterface;
use App\Domain\Repository\CharacterRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CharacterGeneratorSpec extends ObjectBehavior
{
    function let(
        CharacterRepositoryInterface $characterRepository,
        NameProviderInterface $nameProvider,
        PictureProviderInterface $pictureProvider
    ) {
        $this->beConstructedWith(
            $characterRepository,
            $nameProvider,
            $pictureProvider
        );
    }

    function it_creates_a_character_for_a_given_player_in_the_given_game(
        CharacterRepositoryInterface $characterRepository,
        NameProviderInterface $nameProvider,
        PictureProviderInterface $pictureProvider,
        CharacterIdentifier $characterIdentifier,
        Character $flortonCharacter,
        Character $moustachiosCharacter,
        CharacterName $florton,
        CharacterName $moustachios,
        CharacterName $branlouis,
        CharacterPicture $flortonPic,
        CharacterPicture $moustachiosPic,
        CharacterPicture $branlouisPic
    ) {
        $gameIdentifier = GameIdentifier::fromString('super_game');
        $playerIdentifier = 'grena';

        $flortonCharacter->getName()->willReturn($florton);
        $flortonCharacter->getPicture()->willReturn($flortonPic);
        $moustachiosCharacter->getName()->willReturn($moustachios);
        $moustachiosCharacter->getPicture()->willReturn($moustachiosPic);

        $characterRepository->nextIdentifier()->willReturn($characterIdentifier);

        $florton->__toString()->willReturn('Professeur Florton');
        $moustachios->__toString()->willReturn('Moustachios');
        $branlouis->__toString()->willReturn('Branlouis Seltaquet');

        $nameProvider->allForGender(Argument::type('string'))->willReturn([
            $florton,
            $moustachios,
            $branlouis,
        ]);

        $flortonPic->__toString()->willReturn('img/male/flor.png');
        $moustachiosPic->__toString()->willReturn('img/male/mous.png');
        $branlouisPic->__toString()->willReturn('img/male/bran.png');

        $pictureProvider->allForGender(Argument::type('string'))->willReturn([
            $flortonPic,
            $moustachiosPic,
            $branlouisPic,
        ]);

        $characterRepository->findAllByGame($gameIdentifier)->willReturn([
            $flortonCharacter, $moustachiosCharacter
        ]);

        $createdCharacter = $this->forGameAndPlayer($gameIdentifier, $playerIdentifier);

        $createdCharacter->getId()->shouldReturn($characterIdentifier);
        $createdCharacter->getGameIdentifier()->shouldReturn($gameIdentifier);
        $createdCharacter->getPlayerIdentifier()->shouldReturn($playerIdentifier);
        $createdCharacter->getName()->shouldReturn($branlouis);
        $createdCharacter->getPicture()->shouldReturn($branlouisPic);
    }

    function it_throws_an_exception_if_no_more_character_name_is_available(
        CharacterRepositoryInterface $characterRepository,
        NameProviderInterface $nameProvider,
        CharacterIdentifier $characterIdentifier,
        Character $flortonCharacter,
        Character $moustachiosCharacter,
        CharacterName $florton,
        CharacterName $moustachios
    ) {
        $gameIdentifier = GameIdentifier::fromString('super_game');
        $playerIdentifier = 'grena';

        $flortonCharacter->getName()->willReturn($florton);
        $moustachiosCharacter->getName()->willReturn($moustachios);

        $characterRepository->nextIdentifier()->willReturn($characterIdentifier);

        $florton->__toString()->willReturn('Professeur Florton');
        $moustachios->__toString()->willReturn('Moustachios');

        // For test purpose, there is no more name available
        $nameProvider->allForGender(Argument::type('string'))->willReturn([
            $florton,
            $moustachios,
        ]);

        $characterRepository->findAllByGame($gameIdentifier)->willReturn([
            $flortonCharacter, $moustachiosCharacter
        ]);

        $this->shouldThrow(NoNameAvailableException::class)
            ->during('forGameAndPlayer', [$gameIdentifier, $playerIdentifier]);
    }

    function it_throws_an_exception_if_no_more_character_picture_is_available(
        CharacterRepositoryInterface $characterRepository,
        NameProviderInterface $nameProvider,
        PictureProviderInterface $pictureProvider,
        CharacterIdentifier $characterIdentifier,
        Character $flortonCharacter,
        Character $moustachiosCharacter,
        CharacterName $florton,
        CharacterName $moustachios,
        CharacterName $branlouis,
        CharacterPicture $flortonPic,
        CharacterPicture $moustachiosPic
    ) {
        $gameIdentifier = GameIdentifier::fromString('super_game');
        $playerIdentifier = 'grena';

        $flortonCharacter->getName()->willReturn($florton);
        $flortonCharacter->getPicture()->willReturn($flortonPic);
        $moustachiosCharacter->getName()->willReturn($moustachios);
        $moustachiosCharacter->getPicture()->willReturn($moustachiosPic);

        $characterRepository->nextIdentifier()->willReturn($characterIdentifier);

        $florton->__toString()->willReturn('Professeur Florton');
        $moustachios->__toString()->willReturn('Moustachios');
        $branlouis->__toString()->willReturn('Branlouis Seltaquet');

        $nameProvider->allForGender(Argument::type('string'))->willReturn([
            $florton,
            $moustachios,
            $branlouis
        ]);

        $flortonPic->__toString()->willReturn('img/male/flor.png');
        $moustachiosPic->__toString()->willReturn('img/male/mous.png');

        // For test purpose, there is no more picture available
        $pictureProvider->allForGender(Argument::type('string'))->willReturn([
            $flortonPic,
            $moustachiosPic,
        ]);

        $characterRepository->findAllByGame($gameIdentifier)->willReturn([
            $flortonCharacter, $moustachiosCharacter
        ]);

        $this->shouldThrow(NoPictureAvailableException::class)
            ->during('forGameAndPlayer', [$gameIdentifier, $playerIdentifier]);
    }
}
