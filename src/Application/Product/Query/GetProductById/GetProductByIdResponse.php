<?php

declare(strict_types=1);

namespace App\Application\Product\Query\GetProductById;

use App\Application\Product\Query\DTO\ProductDto;

final readonly class GetProductByIdResponse
{
    public function __construct(
        public ProductDto $productDto,
    ) {
    }
}
