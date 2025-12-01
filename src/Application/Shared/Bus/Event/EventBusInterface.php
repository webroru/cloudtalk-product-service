<?php

declare(strict_types=1);

namespace App\Application\Shared\Bus\Event;

use App\Domain\Review\Event\EventInterface;

interface EventBusInterface
{
    public function dispatch(EventInterface $event): void;
}
