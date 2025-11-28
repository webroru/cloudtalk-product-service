<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Domain\Product\Entity\ProductInterface;

interface ProductRepositoryInterface
{
    /** @return ProductInterface[] */
    public function findAll(): array;
    public function findById(string $id): ?ProductInterface;
    public function save(ProductInterface $product): void;
    public function delete(ProductInterface $product): void;
}
