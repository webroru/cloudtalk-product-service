<?php

declare(strict_types=1);

namespace App\Application\Command\UpdateProduct;

use App\Domain\Bus\Command\CommandInterface;

final readonly class UpdateProductCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public float $price,
    ) {
    }
}
