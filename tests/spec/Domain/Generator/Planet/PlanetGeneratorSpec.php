<?php

declare(strict_types=1);

namespace spec\App\Domain\Generator\Planet;

use App\Domain\Generator\Planet\NameGenerator;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Model\Planet\Planet;
use App\Domain\Model\Planet\PlanetIdentifier;
use App\Domain\Model\Planet\PlanetName;
use App\Domain\Model\Planet\PlanetPicture;
use App\Domain\Provider\Planet\PictureProviderInterface;
use App\Domain\Repository\PlanetRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PlanetGeneratorSpec extends ObjectBehavior
{
    function let(
        NameGenerator $nameGenerator,
        PictureProviderInterface $pictureProvider,
        PlanetRepositoryInterface $planetRepository
    ) {
        $this->beConstructedWith(
            $nameGenerator,
            $pictureProvider,
            $planetRepository
        );
    }

    function it_creates_a_planet_for_a_given_game(
        NameGenerator $nameGenerator,
        PictureProviderInterface $pictureProvider,
        PlanetRepositoryInterface $planetRepository,
        PlanetIdentifier $planetIdentifier,
        PlanetPicture $planetPicture,
        PlanetName $planetName,
        GameIdentifier $gameIdentifier
    ) {
        $nameGenerator->getName()->willReturn($planetName);
        $planetRepository->nextIdentifier()->willReturn($planetIdentifier);
        $pictureProvider->forPlanet(Argument::type(Planet::class))->willReturn($planetPicture);

        $planet = $this->forGame($gameIdentifier);

        $planet->shouldBeAnInstanceOf(Planet::class);
        $planet->getId()->shouldReturn($planetIdentifier);
        $planet->getName()->shouldReturn($planetName);
        $planet->getGameId()->shouldReturn($gameIdentifier);
        $planet->getPicture()->shouldReturn($planetPicture);
    }
}
