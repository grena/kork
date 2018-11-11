<?php

declare(strict_types=1);

namespace App\Application\Event;

use App\Domain\Event\EventHandlerInterface;
use App\Domain\Event\EventInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class EventHandlerRegistry
{
    private $eventHandlers = [];

    public function register(EventHandlerInterface $eventHandler)
    {
        $this->eventHandlers[] = $eventHandler;
    }

    /**
     * @return EventHandlerInterface[]
     */
    public function getHandlers(EventInterface $event): array
    {
        $supportedHandlers = array_filter($this->eventHandlers, function (EventHandlerInterface $eventHandler) use ($event) {
            return $eventHandler->supports($event);
        });

        if (empty($supportedHandlers)) {
            throw new \RuntimeException(
                sprintf('No handler found for the event "%s"', get_class($event))
            );
        }

        return array_values($supportedHandlers);
    }
}
