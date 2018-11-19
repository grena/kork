<?php

declare(strict_types=1);

namespace App\Infrastructure\Library\Provider\Planet;

use App\Domain\Model\Planet\Planet;
use App\Domain\Model\Planet\PlanetPicture;
use App\Domain\Provider\Planet\PictureProviderInterface;
use Odin;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class PictureProvider implements PictureProviderInterface
{
    /** @var string */
    private $planetPicturesDirectory;

    /** @var Filesystem */
    private $filesystem;

    public function __construct(string $planetPicturesDirectory, Filesystem $filesystem)
    {
        $this->planetPicturesDirectory = $planetPicturesDirectory;
        $this->filesystem = $filesystem;
    }

    public function forPlanet(Planet $planet): PlanetPicture
    {
        $planetPicturePath = sprintf('%s/%s', $this->planetPicturesDirectory, $planet->getGameId());

        if (!$this->filesystem->exists($planetPicturePath)) {
            $this->filesystem->mkdir($planetPicturePath);
        }

        $configuration = new Odin\Configuration(
            $planetPicturePath,
            $planet->getSeed()->intValue()
        );

        $planetPicture = new Odin\Planet($configuration);
        $planetPicture->diameter(300);

        switch ((string) $planet->getBiome()) {
            case 'ashes':
                $planetPicture->ashes();
                break;
            case 'atoll':
                $planetPicture->atoll();
                break;
            case 'forest':
                $planetPicture->forest();
                break;
            case 'lava':
                $planetPicture->lava();
                break;
            case 'toxic':
                $planetPicture->toxic();
                break;
            default:
                throw new \RuntimeException(
                    sprintf('Biome with name %s not supported', (string) $planet->getBiome())
                );
        }

        $image = $planetPicture->render();

        return PlanetPicture::fromString(sprintf(
            'img/planets/%s/%s',
            $planet->getGameId(),
            $image->getFilename()
        ));
    }
}
