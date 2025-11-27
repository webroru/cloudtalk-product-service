<?php

declare(strict_types=1);

namespace App\Application\Shared\Event;

interface EventBusInterface
{
    public function dispatch(object $event): void;
}
