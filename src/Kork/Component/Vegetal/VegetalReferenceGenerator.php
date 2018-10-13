<?php

namespace Kork\Component\Vegetal;


use Doctrine\Common\Collections\ArrayCollection;
use Kork\Bundle\AppBundle\Doctrine\Repository\PlantSpecieRepository;
use Kork\Bundle\AppBundle\Entity\Game;

class VegetalReferenceGenerator
{
    /** @var PlantSpecieRepository */
    private $vegetalReferenceRepository;

    /** @var string */
    private $rootDir;

    /**
     * @param PlantSpecieRepository $vegetalReferenceRepository
     */
    public function __construct(
        PlantSpecieRepository $vegetalReferenceRepository,
        string $rootDir
    ) {
        $this->vegetalReferenceRepository = $vegetalReferenceRepository;
        $this->rootDir = $rootDir;
    }

    public function generate(Game $game)
    {
        $vegetalReferencesData = $this->vegetalReferenceRepository->findAll();
        $names = $this->getNames();
        shuffle($names);

        $vegetalReferences = new ArrayCollection();
        foreach ($vegetalReferencesData as $vegetalReferenceData) {
            $name = array_shift($names);
            $vegetalReferenceData->setName($name);
            $vegetalReferences->add($vegetalReferenceData);
        }

        $game->setVegetalReferences($vegetalReferences);
    }

    private function getNames(): array
    {
        $filename = sprintf('%s/../data/ressource_names.txt', $this->rootDir);

        return file($filename);
    }
}
