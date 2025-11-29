<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Product\Entity\Product;
use App\Domain\Product\Factory\ProductFactoryInterface;
use App\Domain\Product\ValueObject\ProductId;

final class ProductFactory implements ProductFactoryInterface
{
    public function create(string $name, string $description, float $price): Product
    {
        return new Product(
            id: ProductId::generate(),
            name: $name,
            price: $price,
            description: $description
        );
    }
}
