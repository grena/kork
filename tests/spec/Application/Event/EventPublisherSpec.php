<?php

declare(strict_types=1);

namespace spec\App\Application\Event;

use App\Application\Event\EventHandlerRegistry;
use App\Domain\Event\EventHandlerInterface;
use App\Domain\Event\EventInterface;
use PhpSpec\ObjectBehavior;

class EventPublisherSpec extends ObjectBehavior
{
    function let(EventHandlerRegistry $eventHandlerRegistry)
    {
        $this->beConstructedWith($eventHandlerRegistry);
    }

    function it_publishes_an_event_and_ensures_handlers_treat_it(
        EventHandlerRegistry $eventHandlerRegistry,
        EventInterface $gameEvent,
        EventHandlerInterface $gameHandler,
        EventHandlerInterface $otherGameHandler
    ) {
        $eventHandlerRegistry->getHandlers($gameEvent)
            ->willReturn([$gameHandler, $otherGameHandler]);

        $gameHandler->handle($gameEvent)->shouldBeCalled();
        $otherGameHandler->handle($gameEvent)->shouldBeCalled();

        $this->publish($gameEvent);
    }

    function no_handler_is_called_if_no_one_treat_this_event(
        EventHandlerRegistry $eventHandlerRegistry,
        EventInterface $gameEvent,
        EventHandlerInterface $gameHandler
    ) {
        $eventHandlerRegistry->getHandlers($gameEvent)
            ->willReturn([]);

        $gameHandler->handle($gameEvent)->shouldNotBeCalled();

        $this->publish($gameEvent);
    }
}
