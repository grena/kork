<?php

declare(strict_types=1);

namespace App\Domain\Event;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface EventInterface
{
    public function getName(): string;
}
