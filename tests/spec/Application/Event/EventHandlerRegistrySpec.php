<?php

declare(strict_types=1);

namespace spec\App\Application\Event;

use App\Domain\Event\EventHandlerInterface;
use App\Domain\Event\EventInterface;
use PhpSpec\ObjectBehavior;

class EventHandlerRegistrySpec extends ObjectBehavior
{
    function it_registers_an_event_handler_and_returns_it(
        EventHandlerInterface $gameEventHandler,
        EventHandlerInterface $otherGameEventHandler,
        EventHandlerInterface $playerEventHandler,
        EventInterface $gameEvent,
        EventInterface $playerEvent
    ) {
        $this->register($gameEventHandler);
        $this->register($otherGameEventHandler);
        $this->register($playerEventHandler);

        $gameEventHandler->supports($gameEvent)->willReturn(true);
        $otherGameEventHandler->supports($gameEvent)->willReturn(true);
        $playerEventHandler->supports($gameEvent)->willReturn(false);

        $gameEventHandler->supports($playerEvent)->willReturn(false);
        $otherGameEventHandler->supports($playerEvent)->willReturn(false);
        $playerEventHandler->supports($playerEvent)->willReturn(true);

        $this->getHandlers($gameEvent)->shouldReturn([$gameEventHandler, $otherGameEventHandler]);
        $this->getHandlers($playerEvent)->shouldReturn([$playerEventHandler]);
    }
}
