<?php

declare(strict_types=1);

namespace App\Application\Product\Command\CreateProduct;

use App\Application\Shared\Bus\Command\CommandInterface;

final readonly class CreateProductCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $description,
        public float $price,
    ) {
    }
}
