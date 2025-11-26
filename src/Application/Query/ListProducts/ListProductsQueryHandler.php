<?php

declare(strict_types=1);

namespace App\Application\Query\ListProducts;

use App\Application\Query\DTO\ProductDto;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;

final readonly class ListProductsQueryHandler
{
    public function __construct(
        private ProductRepositoryInterface $repository
    ) {
    }

    public function __invoke(ListProductsQuery $query): ListProductsResponse
    {
        $products = $this->repository->findAll();

        $dtos = array_map(
            fn(Product $product) => new ProductDto(
                id: $product->getId()->toString(),
                name: $product->getName(),
                price: $product->getPrice(),
                description: $product->getDescription(),
            ),
            $products,
        );

        return new ListProductsResponse($dtos);
    }
}
