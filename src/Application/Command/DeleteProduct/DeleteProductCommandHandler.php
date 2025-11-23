<?php

declare(strict_types=1);

namespace App\Application\Command\DeleteProduct;

use App\Domain\Repository\ProductRepositoryInterface;

final readonly class DeleteProductCommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $repository,
    ) {
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $product = $this->repository->findById($command->id);

        if ($product === null) {
            throw new \RuntimeException('Product not found.');
        }

        $this->repository->delete($product);
    }
}
