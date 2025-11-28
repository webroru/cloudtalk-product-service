<?php

declare(strict_types=1);

namespace App\Application\Product\Command\DeleteProduct;

use App\Application\Shared\Bus\Command\CommandInterface;

final readonly class DeleteProductCommand implements CommandInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
