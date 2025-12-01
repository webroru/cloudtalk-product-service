<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Event;

use App\Application\Shared\Bus\Event\EventBusInterface;

class EventBus implements EventBusInterface
{

    public function dispatch(object $event): void
    {
        // TODO: Implement dispatch() method.
    }
}
