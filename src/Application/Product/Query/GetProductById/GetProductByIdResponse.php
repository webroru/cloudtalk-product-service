<?php

declare(strict_types=1);

namespace App\Application\Product\Query\GetProductById;

use App\Application\Product\Query\DTO\ProductDto;
use App\Application\Shared\Bus\Query\ResponseInterface;

final readonly class GetProductByIdResponse implements ResponseInterface
{
    public function __construct(
        public ProductDto $productDto,
    ) {
    }
}
