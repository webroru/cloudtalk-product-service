<?php

declare(strict_types=1);

namespace App\Application\Product\Command\UpdateProduct;

use App\Application\Shared\Bus\Command\CommandHandlerInterface;
use App\Domain\Product\Repository\ProductRepositoryInterface;

final readonly class UpdateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $repository,
    ) {
    }

    public function __invoke(UpdateProductCommand $command): void
    {
        $product = $this->repository->findById($command->id);

        if ($product === null) {
            throw new \RuntimeException('Product not found.');
        }

        $product->setName($command->name)
            ->setDescription($command->description)
            ->setPrice($command->price)
        ;

        $this->repository->save($product);
    }
}
