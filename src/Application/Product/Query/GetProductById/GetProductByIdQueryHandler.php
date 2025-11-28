<?php

declare(strict_types=1);

namespace App\Application\Product\Query\GetProductById;

use App\Application\Product\Query\DTO\ProductDto;
use App\Application\Shared\Bus\Query\QueryHandlerInterface;
use App\Domain\Product\Repository\ProductRepositoryInterface;

final readonly class GetProductByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {
    }

    public function __invoke(GetProductByIdQuery $query): GetProductByIdResponse
    {
        $product = $this->repository->findById($query->id);

        return new GetProductByIdResponse(new ProductDto(
            id: $product->getId()->toString(),
            name: $product->getName(),
            price: $product->getPrice(),
            description: $product->getDescription(),
        ));
    }
}
