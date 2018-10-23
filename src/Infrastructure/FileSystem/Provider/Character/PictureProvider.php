<?php

declare(strict_types=1);

namespace App\Infrastructure\FileSystem\Provider\Character;

use App\Domain\Model\Character\CharacterPicture;
use App\Domain\Provider\Character\PictureProviderInterface;
use Symfony\Component\Finder\Finder;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PictureProvider implements PictureProviderInterface
{
    /** @var string */
    private $characterPicturesDirectory;

    public function __construct(string $characterPicturesDirectory)
    {
        $this->characterPicturesDirectory = $characterPicturesDirectory;
    }

    public function allForGender(string $gender): array
    {
        $pictureFolder = sprintf('%s/%s', $this->characterPicturesDirectory, $gender);

        $finder = new Finder();
        $finder->files()->in($pictureFolder);

        $pictures = [];
        foreach ($finder as $file) {
            $filePath = sprintf('img/characters/%s/%s', $gender, $file->getRelativePathname());
            $pictures[] = CharacterPicture::fromString($filePath);
        }

        return $pictures;
    }
}
