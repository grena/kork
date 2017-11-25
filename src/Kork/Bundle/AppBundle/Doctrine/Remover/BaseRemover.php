<?php

namespace Kork\Bundle\AppBundle\Doctrine\Remover;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;
use Kork\Component\Remover\RemoverInterface;

/**
 * Base remover, declared as different services for different classes
 *
 * @author Adrien Pétremann <hello@grena.fr>
 * @copyright Copyright (c) 2017, Mech Shrimp Studios.
 */
class BaseRemover implements RemoverInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var string */
    protected $removedClass;

    /**
     * @param ObjectManager $objectManager
     * @param string        $removedClass
     */
    public function __construct(ObjectManager $objectManager, $removedClass)
    {
        $this->objectManager = $objectManager;
        $this->removedClass = $removedClass;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($object, array $options = [])
    {
        if (false === ($object instanceof $this->removedClass)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expects a "%s", "%s" provided.',
                    $this->removedClass,
                    ClassUtils::getClass($object)
                )
            );
        }

        $this->objectManager->remove($object);
        $this->objectManager->flush();
    }
}
