<?php

declare(strict_types=1);

namespace App\Application\Product\Query\ListProducts;

use App\Application\Product\Query\DTO\ProductDto;

final readonly class ListProductsResponse
{
    /**
     * @param ProductDto[] $products
     */
    public function __construct(public array $products)
    {
    }
}
