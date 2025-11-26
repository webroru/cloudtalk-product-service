<?php

declare(strict_types=1);

namespace App\Application\Query\GetProductById;

use App\Application\Query\DTO\ProductDto;
use App\Domain\Repository\ProductRepositoryInterface;

final readonly class GetProductByIdQueryHandler
{
    public function __construct(private ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(GetProductByIdQuery $query): GetProductByIdResponse
    {
        $product = $this->repository->findById($query->id()->toString());

        return new GetProductByIdResponse(new ProductDto(
            id: $product->getId()->toString(),
            name: $product->getName(),
            price: $product->getPrice(),
            description: $product->getDescription(),
        ));
    }
}
