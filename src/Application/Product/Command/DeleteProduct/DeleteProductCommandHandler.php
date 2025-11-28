<?php

declare(strict_types=1);

namespace App\Application\Product\Command\DeleteProduct;

use App\Application\Shared\Bus\Command\CommandHandlerInterface;
use App\Domain\Product\Repository\ProductRepositoryInterface;

final readonly class DeleteProductCommandHandler implements CommandHandlerInterface
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

        $this->repository->remove($product);
    }
}
