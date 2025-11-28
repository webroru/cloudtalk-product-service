<?php

declare(strict_types=1);

namespace App\Application\Product\Command\UpdateProduct;

use App\Application\Shared\Bus\Command\CommandInterface;
use App\Domain\Product\ValueObject\ProductId;

final readonly class UpdateProductCommand implements CommandInterface
{
    public function __construct(
        public ProductId $id,
        public string $name,
        public string $description,
        public float $price,
    ) {
    }
}
