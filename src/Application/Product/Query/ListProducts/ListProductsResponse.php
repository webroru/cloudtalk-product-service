<?php

declare(strict_types=1);

namespace App\Application\Product\Query\ListProducts;

use App\Application\Product\Query\DTO\ProductDto;
use App\Application\Shared\Bus\Query\ResponseInterface;

final readonly class ListProductsResponse implements ResponseInterface
{
    /**
     * @param ProductDto[] $products
     */
    public function __construct(public array $products)
    {
    }
}
