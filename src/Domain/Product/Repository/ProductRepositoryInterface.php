<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Domain\Product\Entity\ProductInterface;
use App\Domain\Product\ValueObject\ProductId;

interface ProductRepositoryInterface
{
    /** @return ProductInterface[] */
    public function findAll(): array;
    public function findById(ProductId $id): ?ProductInterface;
    public function save(ProductInterface $product): void;
    public function remove(ProductInterface $product): void;
}
