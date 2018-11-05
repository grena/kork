<?php

declare(strict_types=1);

namespace App\Domain\Event;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
interface EventHandlerInterface
{
    public function supports(EventInterface $event): bool;
    public function handle(EventInterface $event): void;
}
