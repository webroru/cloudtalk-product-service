<?php

declare(strict_types=1);

namespace App\Application\Product\Command\CreateProduct;

use App\Application\Shared\Bus\Command\CommandHandlerInterface;
use App\Domain\Product\Factory\ProductFactoryInterface;
use App\Domain\Product\Repository\ProductRepositoryInterface;

final readonly class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private ProductFactoryInterface $factory,
    ) {
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $product = $this->factory->create(
            name: $command->name,
            description: $command->description,
            price: $command->price
        );

        $this->repository->save($product);
    }
}
