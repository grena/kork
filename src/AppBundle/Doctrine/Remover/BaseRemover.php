<?php

namespace AppBundle\Doctrine\Remover;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;

/**
 * Base remover, declared as different services for different classes
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class BaseRemover
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
