<?php

declare(strict_types=1);

namespace App\Domain\Generator\Character;

use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterName;
use App\Domain\Model\Character\CharacterPicture;
use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Provider\Character\NameProviderInterface;
use App\Domain\Provider\Character\PictureProviderInterface;
use App\Domain\Repository\CharacterRepositoryInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CharacterGenerator implements CharacterGeneratorInterface
{
    /** @var CharacterRepositoryInterface */
    private $characterRepository;

    /** @var NameProviderInterface */
    private $nameProvider;

    /** @var PictureProviderInterface */
    private $pictureProvider;

    public function __construct(
        CharacterRepositoryInterface $characterRepository,
        NameProviderInterface $nameProvider,
        PictureProviderInterface $pictureProvider
    ) {
        $this->characterRepository = $characterRepository;
        $this->nameProvider = $nameProvider;
        $this->pictureProvider = $pictureProvider;
    }

    public function forGameAndPlayer(GameIdentifier $gameIdentifier, string $playerIdentifier): Character
    {
        $genders = ['male', 'female', 'other'];
        $gender = $genders[rand(0, 2)];

        $existingCharacters = $this->characterRepository->findAllByGame($gameIdentifier);

        $name = $this->getAvailableName($gameIdentifier, $gender, $existingCharacters);
        $picture = $this->getAvailablePicture($gameIdentifier, $gender, $existingCharacters);

        return Character::create(
            $this->characterRepository->nextIdentifier(),
            $gameIdentifier,
            $playerIdentifier,
            $name,
            $picture
        );
    }

    private function getAvailableName(
        GameIdentifier $gameIdentifier,
        string $gender,
        array $existingCharacters
    ): CharacterName {
        $unavailableNames = array_map(function (Character $character) {
            return $character->getName();
        }, $existingCharacters);

        $allNames = $this->nameProvider->allForGender($gender);
        $availableNames = array_diff($allNames, $unavailableNames);
        shuffle($availableNames);

        if (empty($availableNames)) {
            throw NoNameAvailableException::withGenderAndGame($gender, $gameIdentifier);
        }

        return current($availableNames);
    }

    private function getAvailablePicture(
        GameIdentifier $gameIdentifier,
        string $gender,
        array $existingCharacters
    ): CharacterPicture {
        $unavailablePictures = array_map(function (Character $character) {
            return $character->getPicture();
        }, $existingCharacters);

        $allPictures = $this->pictureProvider->allForGender($gender);
        $availablePictures = array_diff($allPictures, $unavailablePictures);
        shuffle($availablePictures);

        if (empty($availablePictures)) {
            throw NoPictureAvailableException::withGenderAndGame($gender, $gameIdentifier);
        }

        return current($availablePictures);
    }
}
