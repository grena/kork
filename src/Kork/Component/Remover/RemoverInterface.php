<?php

namespace Kork\Component\Remover;

/**
 * Remover interface, provides a minimal contract to remove a single business object
 *
 * @author Adrien Pétremann <hello@grena.fr>
 * @copyright Copyright (c) 2017, Mech Shrimp Studios.
 */
interface RemoverInterface
{
    /**
     * Delete a single object
     *
     * @param mixed $object  The object to delete
     * @param array $options The delete options
     *
     * @throws \InvalidArgumentException
     */
    public function remove($object, array $options = []);
}
