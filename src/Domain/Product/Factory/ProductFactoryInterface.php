<?php

declare(strict_types=1);

namespace App\Domain\Product\Factory;

use App\Domain\Product\Entity\ProductInterface;

interface ProductFactoryInterface
{
    public function create(
        string $name,
        string $description,
        float $price,
    ): ProductInterface;
}
