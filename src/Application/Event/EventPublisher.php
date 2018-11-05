<?php

declare(strict_types=1);

namespace App\Application\Event;

use App\Domain\Event\EventInterface;
use App\Domain\Event\EventPublisherInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class EventPublisher implements EventPublisherInterface
{
    /** @var EventHandlerRegistry */
    private $eventHandlerRegistry;

    public function __construct(EventHandlerRegistry $eventHandlerRegistry)
    {
        $this->eventHandlerRegistry = $eventHandlerRegistry;
    }

    public function publish(EventInterface $domainEvent): void
    {
        $eventHandlers = $this->eventHandlerRegistry->getHandlers($domainEvent);

        foreach ($eventHandlers as $eventHandler) {
            $eventHandler->handle($domainEvent);
        }
    }
}
