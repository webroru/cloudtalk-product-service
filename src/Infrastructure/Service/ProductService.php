<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Application\Product\Command\DeleteProduct\DeleteProductCommand;
use App\Application\Product\Command\UpdateProduct\UpdateProductCommand;
use App\Application\Product\Query\GetProductById\GetProductByIdQuery;
use App\Application\Product\Query\ListProducts\ListProductsQuery;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\ValueObject\ProductId;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class ProductService
{
    public function __construct(private MessageBusInterface $commandBus) {}

    public function createProduct(string $name, string $description, float $price): void
    {
        $command = new CreateProductCommand($name, $description, $price);
        $this->commandBus->dispatch($command);
    }

    public function updateProduct(ProductId $id, string $name, string $description, float $price): void
    {
        $command = new UpdateProductCommand(
            id: $id,
            name: $name,
            description: $description,
            price: $price
        );
        $this->commandBus->dispatch($command);
    }

    public function deleteProduct(ProductId $id): void
    {
        $command = new DeleteProductCommand(id: $id);
        $this->commandBus->dispatch($command);
    }

    public function getProduct(ProductId $id): Product
    {
        $command = new GetProductByIdQuery(id: $id);
        $envelope = $this->commandBus->dispatch($command);
        return $envelope->last(MessageBusInterface::class)->getResult();
    }

    public function listProducts(): array
    {
        $command = new ListProductsQuery();
        $envelope = $this->commandBus->dispatch($command);
        return $envelope->last(MessageBusInterface::class)->getResult();
    }
}
