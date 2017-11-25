<?php

namespace Kork\Component\Saver;

/**
 * Saver interface, provides a minimal contract to save a single business object
 *
 * @author Adrien Pétremann <hello@grena.fr>
 * @copyright Copyright (c) 2017, Mech Shrimp Studios.
 */
interface SaverInterface
{
    /**
     * Save a single object
     *
     * @param mixed $object  The object to save
     * @param array $options The saving options
     *
     * @throws \InvalidArgumentException
     */
    public function save($object, array $options = []);
}
