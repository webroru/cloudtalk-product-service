<?php

declare(strict_types=1);

namespace App\Application\Product\Command\DeleteProduct;

use App\Application\Shared\Bus\Command\CommandInterface;
use App\Domain\Product\ValueObject\ProductId;

final readonly class DeleteProductCommand implements CommandInterface
{
    public function __construct(
        public ProductId $id,
    ) {
    }
}
