<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Command;

use App\Application\Shared\Bus\Command\CommandBusInterface;
use App\Application\Shared\Bus\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerCommandBus implements CommandBusInterface
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
