<?php

declare(strict_types=1);

namespace App\Application\Shared\Bus\Event;

interface EventBusInterface
{
    public function dispatch(object $event): void;
}
