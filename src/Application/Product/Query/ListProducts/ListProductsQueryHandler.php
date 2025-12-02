<?php

declare(strict_types=1);

namespace App\Application\Product\Query\ListProducts;

use App\Application\Product\Query\DTO\ProductDto;
use App\Application\Product\Service\ProductRatingService;
use App\Application\Shared\Bus\Query\QueryHandlerInterface;
use App\Domain\Product\Entity\ProductInterface;
use App\Domain\Product\Repository\ProductRepositoryInterface;

final readonly class ListProductsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private ProductRatingService $ratingService,
    ) {
    }

    public function __invoke(ListProductsQuery $query): ListProductsResponse
    {
        $products = $this->repository->findAll();

        $dtos = array_map(
            fn(ProductInterface $product) => new ProductDto(
                id: $product->getId()->toString(),
                name: $product->getName(),
                price: $product->getPrice(),
                description: $product->getDescription(),
                averageRating: $this->ratingService->getRating($product->getId()->toString()),
            ),
            $products,
        );

        return new ListProductsResponse($dtos);
    }
}
