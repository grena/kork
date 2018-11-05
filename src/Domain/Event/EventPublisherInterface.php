<?php

declare(strict_types=1);

namespace App\Domain\Event;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface EventPublisherInterface
{
    public function publish(EventInterface $event): void;
}
