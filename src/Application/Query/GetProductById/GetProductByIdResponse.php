<?php

declare(strict_types=1);

namespace App\Application\Query\GetProductById;

use App\Application\Query\DTO\ProductDto;

final readonly class GetProductByIdResponse
{
    public function __construct(
        public ProductDto $productDto,
    ) {
    }
}
