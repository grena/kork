<?php

namespace Kork\Bundle\AppBundle\Doctrine\Saver;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;
use Kork\Component\Saver\SaverInterface;

/**
 * Base saver, declared as different services for different classes
 *
 * @author Adrien Pétremann <hello@grena.fr>
 * @copyright Copyright (c) 2017, Mech Shrimp Studios.
 */
class BaseSaver implements SaverInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var string */
    protected $savedClass;

    /**
     * @param ObjectManager $objectManager
     * @param string        $savedClass
     */
    public function __construct(ObjectManager $objectManager, $savedClass)
    {
        $this->objectManager = $objectManager;
        $this->savedClass = $savedClass;
    }

    /**
     * {@inheritdoc}
     */
    public function save($object, array $options = [])
    {
        if (false === ($object instanceof $this->savedClass)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expects a "%s", "%s" provided.',
                    $this->savedClass,
                    ClassUtils::getClass($object)
                )
            );
        }

        $this->objectManager->persist($object);
        $this->objectManager->flush();
    }
}
