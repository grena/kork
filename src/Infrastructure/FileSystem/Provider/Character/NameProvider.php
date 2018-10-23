<?php

declare(strict_types=1);

namespace App\Infrastructure\FileSystem\Provider\Character;

use App\Domain\Model\Character\CharacterName;
use App\Domain\Provider\Character\NameProviderInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class NameProvider implements NameProviderInterface
{
    /** @var string */
    private $characterNamesDirectory;

    public function __construct(string $characterNamesDirectory)
    {
        $this->characterNamesDirectory = $characterNamesDirectory;
    }

    public function allForGender(string $gender): array
    {
        $filename = sprintf('%s/%s/names.txt', $this->characterNamesDirectory, $gender);

        $names = file($filename);
        $names = array_map(function (string $rawName) {
            return CharacterName::fromString(trim($rawName));
        }, $names);

        return $names;
    }
}
