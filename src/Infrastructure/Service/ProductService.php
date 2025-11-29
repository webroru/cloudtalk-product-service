<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class ProductService
{
    public function __construct(private MessageBusInterface $commandBus) {}

    public function createProduct(string $name, string $description, float $price): void
    {
        $command = new CreateProductCommand($name, $description, $price);
        $this->commandBus->dispatch($command);
    }
}
