<?php

declare(strict_types=1);

namespace App\Application\Product\Query\DTO;

final readonly class ProductDto
{
    public function __construct(
        public string $id,
        public string $name,
        public float $price,
        public ?string $description,
    ) {
    }
}
