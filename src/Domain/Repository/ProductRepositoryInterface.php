<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\ProductInterface;

interface ProductRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): ?ProductInterface;
    public function save(ProductInterface $product): void;
    public function delete(ProductInterface $product): void;
}
