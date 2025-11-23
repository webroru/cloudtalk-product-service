<?php

declare(strict_types=1);

namespace App\Application\Command\CreateProduct;

use App\Domain\Factory\ProductFactoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;

readonly class CreateProductCommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private ProductFactoryInterface $factory,
    ) {
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $product = $this->factory->create(
            name: $command->name(),
            description: $command->description(),
            price: $command->price()
        );

        $this->repository->save($product);
    }
}
