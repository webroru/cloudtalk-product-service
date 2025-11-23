<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\ProductInterface;

interface ProductFactoryInterface
{
    public function create(
        string $name,
        string $description,
        float $price,
    ): ProductInterface;
}
