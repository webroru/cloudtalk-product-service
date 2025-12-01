<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Event;

use App\Application\Shared\Bus\Event\EventBusInterface;
use App\Domain\Review\Event\EventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerEventBus implements EventBusInterface
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function dispatch(EventInterface $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
