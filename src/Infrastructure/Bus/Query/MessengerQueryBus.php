<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Query;

use App\Application\Shared\Bus\Query\QueryBusInterface;
use App\Application\Shared\Bus\Query\QueryInterface;
use App\Application\Shared\Bus\Query\ResponseInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class MessengerQueryBus implements QueryBusInterface
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {}

    public function ask(QueryInterface $query): ?ResponseInterface
    {
        $envelope = $this->messageBus->dispatch($query);

        $handled = $envelope->last(HandledStamp::class);

        if (!$handled) {
            throw new \RuntimeException('Query was not handled.');
        }

        return $handled->getResult();
    }
}
